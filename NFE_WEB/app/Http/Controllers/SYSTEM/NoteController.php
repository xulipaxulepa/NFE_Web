<?php

namespace App\Http\Controllers\SYSTEM;

use App\Model\Cfop;
use App\Model\EnterpriseNote;
use App\Model\Ncm;
use App\Model\Note;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use NFePHP\DA\Legacy\FilesFolders;
use NFePHP\DA\NFe\Danfe;
use NFePHP\NFe\Make;

class NoteController extends Controller
{
    private $fileXML = "arquive/xmls/";
    private $filePDF = "arquive/pdfs/";
    private $fileJSON = "arquive/jsons/";
    private $nameSender = NULL;
    private $walkingXML = NULL;
    private $walkingPDF = NULL;
    private $xml = NULL;
    private $configJson = null;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verify_profile');
        $this->middleware('verify_enterprise');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        return View::make('note.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        $count = EnterpriseNote::where('enterprise', Session::get('enterprise')->id)->first();
        $notes = Note::orderBy('date', 'ASC')->get();
        if ($count->amount <= count($notes)) {
            return Redirect::to('note');
        } else {
            $freight = [];
            $freight[0] = __("fields.note_freight_issuer");
            $freight[1] = __("fields.note_freight_recipient");
            $freight[2] = __("fields.note_freight_the_3rd");
            $freight[9] = __("fields.note_freight_not");

            return View::make('note.create')->with('freight', $freight);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        $count = EnterpriseNote::where('enterprise', Session::get('enterprise')->id)->first();
        $notes = Note::orderBy('date', 'ASC')->get();
        if ($count->amount > count($notes)) {
            $nfe = new Make();

            $std = new \stdClass();
            $std->versao = "4.0";
            $std->pk_nItem = null; //deixe essa variavel sempre como NULL
            $elem = $nfe->taginfNFe($std);

            //Identificando a NFe
            $codigo = "";
            for ($x = 0; $x < 8; $x++) {
                $codigo .= rand(0, 9);
            }
            $std = new \stdClass();
            $std->cUF = Session::get('enterprise')->code_state;//Codigo do estado onde a NFe é gerado, MUDAR DE ACORDO COM O ESTADO
            $std->cNF = $codigo;//ESSE CÓDIGO É ALEATÓRIO E GERADO POR NOS
            $std->natOp = Input::get('nature_option');

            $std->indPag = 0; //NÃO EXISTE MAIS NA VERSÃO 4.00

            $std->mod = 55; //Mudando essa variavel tem-se o NFCe(65) mas alguns estados não o aceitam por isso deixa assim
            $std->serie = 1;
            $std->nNF = 2;
            $std->dhEmi = str_replace(' ', 'T', (new \DateTime())->format("Y-m-d H:i:sP")); //COLOCAR A DATA ATUAL USANDO O DATE DO PHP(NO MESMO FORMATO)
            $std->dhSaiEnt = str_replace(' ', 'T', (new \DateTime())->format("Y-m-d H:i:sP")); //COLOCAR A DATA ATUAL USANDO O DATE DO PHP(NO MESMO FORMATO)
            $std->tpNF = 1;
            $std->idDest = 1;
            $std->cMunFG = 3518800;
            $std->tpImp = 1;
            $std->tpEmis = 1; //ESSA VARIAVEL VERIFICA O TIPO DE CONTINGENCIA A SER USADO, A CONTINGENCIA INDICA O QUE FAZER CASO NÃ HAJA INTERNET OU COMUNICAÇÃO COM O SEFAZ
            $std->cDV = 2;
            $std->tpAmb = __("fields.note_approval_environment"); //ESSA VARIAVEL É QUEM DITA SE O AMBIENTE É DE HOMOLOGAÇÃO(TESTE) OU NÃO.
            $std->finNFe = 1;
            $std->indFinal = 0;
            $std->indPres = 0;
            $std->procEmi = '0';
            $std->verProc = null;
            $std->dhCont = null;
            $std->xJust = null;

            $elem = $nfe->tagide($std);

            //Dados do Emitente
            $std = new \stdClass();
            $std->xNome = Session::get('enterprise')->social_name;
            $std->xFant = null;
            $std->IE = Session::get('enterprise')->state_registration;
            $std->IEST = null;
            $std->IM = null;
            $std->CNAE = null;
            $std->CRT = Session::get('enterprise')->tax_regime;

            $cnpj = "";
            $cnpjField = Session::get('enterprise')->cnpj;
            for ($c = 0; $c < strlen($cnpjField); $c++) {
                if (is_numeric($cnpjField[$c])) {
                    $cnpj .= $cnpjField[$c];
                }
            }
            $std->CNPJ = $cnpj;
            $std->CPF = null;

            $elem = $nfe->tagemit($std);

            //Dados de endereço do Emitente
            $std = new \stdClass();
            $std->xLgr = Session::get('enterprise')->place;
            $std->nro = Session::get('enterprise')->number;
            $std->xCpl = Session::get('enterprise')->complement;
            $std->xBairro = Session::get('enterprise')->district;
            $std->cMun = Session::get('enterprise')->code_city; //Código do municipio(Alterar de acordo com o municipio) código como teste, São Paulo.
            $std->xMun = Session::get('enterprise')->city;
            $std->UF = Session::get('enterprise')->state;
            $std->CEP = Session::get('enterprise')->code_postal;
            $std->cPais = 1058; //Código do brasil de acordo com tabela de código dos paises(alterar se for venda para exterior)
            $std->xPais = 'Brasil';
            $fone = "";
            $foneField = !is_null(Session::get('enterprise')->phone) ? Session::get('enterprise')->phone : (!is_null(Session::get('enterprise')->cellphone) ? Session::get('enterprise')->cellphone : NULL);
            for ($f = 0; $f < strlen($foneField); $f++) {
                if (is_numeric($foneField[$f])) {
                    $fone .= $foneField[$f];
                }
            }
            $std->fone = $fone;

            $elem = $nfe->tagenderEmit($std);

            $std = new \stdClass();
            $std->xNome = Input::get('name');
            $std->indIEDest = 9;
            $std->IE = Input::get('state_register_sender');
            $std->ISUF = null;
            $std->IM = null;
            $std->email = null;

            $register = "";
            $registerField = Input::get('register_sender');
            for ($r = 0; $r < strlen($registerField); $r++) {
                if (is_numeric($registerField[$r])) {
                    $register .= $registerField[$r];
                }
            }
            $std->CNPJ = strlen($register) == 14 ? $register : NULL; //indicar apenas um CNPJ ou CPF ou idEstrangeiro
            $std->CPF = strlen($register) == 11 ? $register : NULL; //indicar apenas um CNPJ ou CPF ou idEstrangeiro

            $std->idEstrangeiro = null;

            $elem = $nfe->tagdest($std);

            //Dados de endereço do remetente
            $std = new \stdClass();
            $std->xLgr = Input::get('place_sender');
            $std->nro = Input::get('number_sender');
            $std->xCpl = Input::get('complement_sender');
            $std->xBairro = Input::get('district_sender');
            $std->cMun = Input::get('code_city_sender');
            $std->xMun = Input::get('city_sender');
            $std->UF = Input::get('state_sender');
            $codePostal = "";
            $codePostalField = Input::get('code_postal_sender');
            for ($c = 0; $c < strlen($codePostalField); $c++) {
                if (is_numeric($codePostalField[$c])) {
                    $codePostal .= $codePostalField[$c];
                }
            }
            $std->CEP = $codePostal;
            $std->cPais = 1058;
            $std->xPais = 'Brasil';
            $std->fone = null;

            $elem = $nfe->tagenderDest($std);

            $amountItem = Input::get('amountItem');

            $amountProducts = 0;
            $amountBaseCalculoICMS = 0;
            $amountIPI = 0;
            $amountICMS = 0;
            for ($x = 0; $x < $amountItem; $x++) {
                $product = Product::find(Input::get('id' . $x));

                $ncm = Ncm::find($product->ncm);
                $cfop = Cfop::find($product->cfop);
                //Dados do product ou serviço
                $std = new \stdClass();
                $std->item = ($x + 1); //item da NFe GERAR UM CODIGO PARA O ITEM DO NFE
                $std->cProd = Input::get('id' . $x); //Gerar um código para o product
                $std->xProd = Input::get('name' . $x);
                $std->NCM = $ncm->code;
                $std->CFOP = $cfop->code;
                $std->uCom = $product->unit;
                $std->qCom = Input::get('amount' . $x);
                $std->vUnCom = $product->price;
                $std->vProd = $product->price * $std->qCom;
                $std->uTrib = $product->unit; //Unidade tributária
                $std->qTrib = Input::get('amount' . $x); //Quantia da tributação - VALOR PEGO COMO EXEMPLO
                $std->vUnTrib = $product->price;
                $std->indTot = 1;

                $amountProducts += $product->price * Input::get('amount' . $x);

                $elem = $nfe->tagprod($std);

                //Iniciação dos impostos incidentes no product ou serviço
                $std = new \stdClass();
                $std->item = ($x + 1);
                $std->vTotTrib = $request->input('vProd');
                $nfe->tagimposto($std);

                $baseCalculoICMS = $product->price * Input::get('amount' . $x);
                $amountBaseCalculoICMS += $baseCalculoICMS;
                $valorICMS = $baseCalculoICMS * ($product->aliquota / 100);
                $amountICMS += $valorICMS;
                $ipi = number_format(($baseCalculoICMS * ($product->ipi / 100)), 2);
                $amountIPI += $ipi;

                $cst = Input::get('cst' . $x);
                if ($cst[0] == "0") {
                    if (strlen($cst) > 1) {
                        $cstTemp = "";
                        for ($x = 1; $x < strlen($cst); $x++) {
                            $cstTemp .= $cst[$x];
                        }
                        $cst = $cstTemp;
                    }
                }

                //ICMS(VALORES COMO EXEMPLO)
                $std = new \stdClass();
                $std->item = ($x + 1);
                $std->orig = ($x + 1);
                $std->CST = $cst;
                $std->vBC = $baseCalculoICMS;
                $std->pICMS = $product->aliquota;
                $std->vICMS = $valorICMS;
                $nfe->tagICMS($std);

                //IPI(VALORES COMO EXEMPLO)
                $std = new \stdClass();
                $std->item = ($x + 1);
                $std->CST = $cst;
                $std->vIPI = $ipi;
                $std->pIPI = $product->ipi;
                $nfe->tagIPI($std);

                $std = new \stdClass();
                $std->item = 1;
                $std->orig = 0;
                $std->CST = '00';
                $std->modBC = 0;
                $std->vBC = "0.20";
                $std->pICMS = '18.0000';
                $std->vICMS = '0.04';
                $nfe->tagICMS($std);

            }

            $amountGeneral = ($amountICMS + $amountIPI + Input::get('value_icms') + $amountProducts + Input::get('price_freight') + Input::get('price_secure') + Input::get('price_accessory')) - Input::get('price_off');
            //TOTAL(VALORES COMO EXEMPLO)
            $std = new \stdClass();
            $std->vBC = $amountBaseCalculoICMS;
            $std->vICMS = $amountICMS;
            $std->vICMSDeson = 1000.01;
            $std->vBCST = Input::get('base_icms');
            $std->vST = Input::get('value_icms');
            $std->vProd = $amountProducts;
            $std->vFrete = Input::get('price_freight');
            $std->vSeg = Input::get('price_secure');
            $std->vDesc = Input::get('price_off');
            $std->vOutro = Input::get('price_accessory');
            $std->vIPI = $amountIPI;
            $std->vNF = $amountGeneral;

            $elem = $nfe->tagICMSTot($std);

            //Dados referente a transporte
            $std = new \stdClass();
            $std->modFrete = Input::get('type_freight');
            $nfe->tagtransp($std);

            $std = new \stdClass();
            $std->CNPJ = Input::get('register_freight');
            $std->CPF = null;
            $std->xNome = Input::get('shipping_company');
            $std->IE = '';
            $std->xEnder = Input::get('place_shipping_company');
            $std->xMun = Input::get('city_shipping_company');
            $std->UF = Input::get('state_freight');
            $nfe->tagtransporta($std);

            $std = new \stdClass();
            $std->qVol = Input::get('amount_freight');
            $std->esp = Input::get('specie');
            $std->nVol = time(); //NUMERAÇÃO DO VOLUME
            $nfe->tagvol($std);

            //Dados da fatura
            $std = new \stdClass();
            $std->nFat = rand(1000, 1000000); //Gerar um numero para a fatura
            $valueOrigine = $amountProducts; //VALOR DA FATURA = VALOR DO PRODUCT*QUANTIDADE COMPRADA
            $std->vOrig = $valueOrigine;
            $std->vDesc = null;
            $std->vLiq = $valueOrigine;

            $elem = $nfe->tagfat($std);

            //Formas de pagamento
            $std = new \stdClass();
            $std->vTroco = null; //incluso no layout 4.00, obrigatório informar para NFCe (65)

            $elem = $nfe->tagpag($std);

            //Detalhamento da forma de pagamento
            $std = new \stdClass();
            $std->tPag = '03';
            /*tPag é usualmente:
                  14 = Duplicata Mercantil
                  15 = Boleto Bancário
                  90 = Sem pagamento
                  99 = Outros*/
            $std->vPag = $valueOrigine; //Obs: deve ser informado o valor pago pelo cliente
            $std->CNPJ = strlen($register) == 14 ? $register : NULL; //indicar apenas um CNPJ ou CPF ou idEstrangeiro
            $std->tBand = '01';
            $std->cAut = '3333333';
            $std->tpIntegra = 1; //incluso na NT 2015/002
            $std->indPag = '0'; //0= Pagamento à Vista 1= Pagamento à Prazo

            $elem = $nfe->tagdetPag($std);

            //Armazena o XML em formato string
            $this->xml = $nfe->getXML(); // O conteúdo do XML fica armazenado na variável $xml

            //Armazena o XML no pc(Usa o nome do emitente como o nome do xml)
            //pega o nome do emitente do XML e atribui um identificador ao xml sendo gerado
            $this->nameSender = Session::get('enterprise')->id . time();

            file_put_contents(public_path($this->fileXML . $this->nameSender . '.xml'), $this->xml);
            $this->walkingXML = public_path($this->fileXML . $this->nameSender . '.xml');

            //CHAMA A FUNÇÃO QUE MONTA O PDF USANDO COMO BASE O XML
            $this->makePDF($this->walkingXML);
            //exit;

            //Necessário para assinar o XML
            $cnpjConfig = "";
            $cnpjEnterprise = Session::get('enterprise')->cnpj;
            for ($ce = 0; $ce < strlen($cnpjEnterprise); $ce++) {
                if (is_numeric($cnpjEnterprise[$ce])) {
                    $cnpjConfig .= $cnpjEnterprise[$ce];
                }
            }

            $config = [
                "atualizacao" => date("Y-m-d H:i:s"), //Colocar data atual
                "tpAmb" => __("fields.note_approval_environment"), // Se deixar o tpAmb como 2 você emitirá a note em ambiente de homologação(teste) e as notes fiscais aqui não tem valor fiscal
                //"verProc" => "1.0.0.0",
                //"verProc" => "1_1_00",
                "razaosocial" => Session::get('enterprise')->social_name,
                "siglaUF" => Session::get('enterprise')->state,
                "cnpj" => $cnpjConfig,
                "schemes" => "PL_008i2",
                "versao" => "4.0",
                "tokenIBPT" => "AAAAAAA" //Token do IBPT
            ];

            $this->configJson = json_encode($config);

            //GUARDA O ARQUIVO JSON CRIADO COM O CONFIGJSON NO PC
            file_put_contents(public_path($this->fileJSON . $this->nameSender . '.json'), $this->configJson);

            $cert = file_get_contents(public_path('upload/certified_enterprise/' . Session::get('enterprise')->certified));
            $json = file_get_contents(public_path($this->fileJSON . $this->nameSender . '.json'));

//        $tools = new Tools($json, Certificate::readPfx($cert, Session::get('enterprise')->password_certified));
//        try {
//            $this->xmlAssinado = $tools->signNFe($this->xml); // O conteúdo do XML assinado fica armazenado na variável $xmlAssinado
//        } catch (\Exception $e) {
//            exit($e->getMessage()); //aqui você trata possíveis exceptions da assinatura
//        }

            $note = new Note();
            $note->date = date("Y-m-d H:i:s");
            $note->recipient = Input::get('social_name_sender');
            $note->pdf = $this->nameSender . '.pdf';
            $note->xml = $this->nameSender . '.xml';
            $note->enterprise = Session::get('enterprise')->id;
            $note->save();
            $enterpriseNote = EnterpriseNote::where('enterprise', Session::get('enterprise')->id)->first();
            Session::flash('success', __("messages.success"));
            if (Note::where('enterprise', Session::get('enterprise')->id)->count() < $enterpriseNote->note) {
                return Redirect::to('note/create');
            } else {
                return Redirect::to('note');
            }
        } else {
            Session::flash('danger', __("messages.fail_note"));
            return Redirect::to('note');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        $note = Note::find($id);
        $note->delete();
        return response()->json(['status' => 'OK']);
    }

    public function download($type, $id)
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        $note = Note::find($id);
        if($type == "pdfs") {
            $file = public_path($this->filePDF . $note->pdf);
            $headers = array('Content-Type: application/pdf');
            return Response::download($file, $note->pdf, $headers);
        } else if($type == "xmls") {
            $file = public_path($this->fileXML . $note->xml);
            $headers = array('Content-Type: application/xml');
            return Response::download($file, $note->xml, $headers);
        }
    }

    public function makePDF(String $walkingXML)
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        $xml = $walkingXML;
        $docxml = FilesFolders::readFile($xml);

        try {
            $logo = public_path(!is_null(Session::get('enterprise')->photo_mini) ? 'upload/photo_enterprise/' . Session::get('enterprise')->photo_mini : 'sem_imagem.jpg');
            $danfe = new Danfe($docxml, 'P', 'A4', $logo, 'I', '');
            $danfe->exibirPIS = FALSE;
            $danfe->exibirIcmsInterestadual = FALSE;

            $id = $danfe->montaDANFE();
            $pdf = $danfe->render();
            //o pdf porde ser exibido como view no browser
            //salvo em arquivo
            //ou setado para download forçado no browser
            //ou ainda gravado na base de dados
            file_put_contents(public_path($this->filePDF . $this->nameSender . '.pdf'), $pdf);
            $this->walkingPDF = public_path($this->filePDF . $this->nameSender . '.pdf');
        } catch (\InvalidArgumentException $e) {
            echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
        }
    }
}