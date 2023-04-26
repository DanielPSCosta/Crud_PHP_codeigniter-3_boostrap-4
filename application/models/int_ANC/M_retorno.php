<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_retorno extends CI_Model
{
    ////////////////////////////////////////////////////////////////////////////////////////////////
    //////   FUNÇÃO PARA RETORNAR OS MOVIMENTAÇÃO DE FÁBRICA ///////////////////////////////////////
    //////   PROJETO BAIXA DE SUCATA                         ///////////////////////////////////////
    //////   CRIADO POR MARCIO SILVA                         ///////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    public function buscaMovimentacao($input)
    {
        // isset($input['value']) == true && $input['value'] != '5' ? $sql .= "  AND A.USUARIO = '$chapa'" : '';
        // set_time_limit(600);
        // $db = $this->load->database(getAmbiente(), true);
        // $sql = "SELECT DISTINCT (A.PRODUTO), A.ALMORIG, B.ECDAL_DESCRICAO
        //           FROM MOVFABR A,  ECDAL B
        //          WHERE A.ALMORIG = B.ECDAL_CODALM
        //            AND A.DTMOV BETWEEN '$input[txtperiodoinicial]' AND '$input[txtperiodofinal]'";
        // isset($input['txtProd']) == true && $input['txtProd'] != '' ? $sql .= " AND A.PRODUTO = '$input[txtProd]'" : '';
        // isset($input['txtProd']) == true && $input['txtProd'] == '' ? $sql .= " AND A.PRODUTO > ''" : '';
        // isset($input['slAlm'])   == true && $input['slAlm']   != '' ? $sql .= " AND A.ALMORIG IN ($input[slAlm])" : '';
        // isset($input['slAlm'])   == true && $input['slAlm']   == '' ? $sql .= " AND A.ALMORIG IN (11,14) " : '';

        // $retorno = $db->query($sql);
        // if ($retorno->num_rows() > 0) {
        //     foreach ($retorno->result() as $linha) :
        //         $sql = "Execute Procedure Bco_Cons_MovProc ('$linha->produto','$linha->almorig')";
        //         $retQde = $db->query($sql);
        //         if ($retQde->row()->sld_processo > 0) {
        //             $retQtde[] = array(
        //                 "produto"     => $linha->produto,
        //                 "almorig"     => $linha->almorig . ' - ' . $linha->ecdal_descricao,
        //                 "pecasverdes" => $retQde->row()->sld_proc01,
        //                 "ttermico"    => $retQde->row()->sld_proc02,
        //                 "retifica"    => $retQde->row()->sld_proc03,
        //                 "operacao"    => $retQde->row()->operacao,
        //                 "qtde"        => $retQde->row()->sld_processo
        //             );
        //         }
        //     endforeach;
        // } else {
        //     $retQtde = 0;
        // }
        // $db->close();
        // return $retQtde;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    //////////////           FUNÇÃO QUE RETORNA DADOS DA TABELA ROMANEIO PARA     ///////////////// 
    //////////////           REIMPRESSÃO DE ROMANEIO                              /////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function listar_romaneios($dados = true)
    {
        // $db = $this->load->database(getAmbiente(), TRUE);
        // $sql_consulta = "SELECT LIMIT 100 ROMANEIO.NROROM,
        //                         TO_CHAR(DATE(ROMANEIO.DTCRIA), '%d/%m/%Y') DATA,
        //                         TO_CHAR(ROMANEIO.DTCRIA, '%H:%M:%S') HORA,
        //                         ROMANEIO.USUCRIA,
        //                         FUNCIONARIO.NOME,
        //                         ROMANEIO.SETOR,
        //                         ROMANEIO.MEIOTRP,
        //                         CASE TRIM(MEIOTRP)
        //                             WHEN 'CB' THEN
        //                                     'CAMINHÃO BAÚ'
        //                             WHEN 'CP' THEN
        //                                     'CAMINHÃO PRANCHA'
        //                             WHEN 'EM' THEN
        //                                     'EMPILHADEIRA'
        //                             WHEN 'ON' THEN
        //                                     'ÔNIBUS'
        //                              END DESCMEIOTRP
        //                             FROM   ROMANEIO, FUNCIONARIO
        //                            WHERE  ROMANEIO.USUCRIA = FUNCIONARIO.CHAPA
        //                              AND   ROMANEIO.ESTATUS = ''
        //                              AND   FUNCIONARIO.ESTATUS = ''";
        // isset($dados['id_romaneio']) == true && $dados['id_romaneio'] !== '' ? $sql_consulta .= " AND NROROM = $dados[id_romaneio] " : '';
        // isset($dados['data']) == true && $dados['data'] !== '' ? $sql_consulta .= " AND DATE(DTCRIA) = '$dados[data]' " : '';
        // isset($dados['sl_setor']) == true && $dados['sl_setor'] !== '' ? $sql_consulta .= " AND ROMANEIO.SETOR = '$dados[sl_setor]' " : '';
        // $sql_consulta .= " ORDER BY DTCRIA DESC";

        // $query_consulta = $db->query(utf8_decode($sql_consulta));
        // if ($query_consulta->num_rows() > 0) {
        //     $retorno = format_result($query_consulta)->result();
        // } else {
        //     $retorno = array();
        // }
        // $db->close();
        // return $retorno;
    }

    /////////////////////////////////////////////////////////////////////////////////////////
    //////////////////              ITENS DA CACAMBA                   //////////////////////
    //////////////////              REIMPRESSAO DE ROMANEIO            //////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////
    public function itens_cacamba($numrom)
    {
        // $sql_consulta = " SELECT * 
        //                     FROM   ROMITENS
        //                    WHERE  NROROM = $numrom
        //                      AND  ESTATUS = '' ";

        // $query_consulta = $this->db->query($sql_consulta);
        // return format_result($query_consulta)->result();
    }

    /////////////////////////////////////////////////////////////////////////////////////////
    /////// RETORNAR ROMANEIO SELECIONADO PARA IMPRESSÃO ////////////////////////////////////
    /////// CRIADO POR MAURICIO                          ////////////////////////////////////
    /////// 13/01/2022                                   ////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////
    public function trazer_impressora()
    {
        // $db = $this->load->database(getAmbiente(), TRUE);

        // $sql = $db->query("SELECT GRPLSTEMP 
        //                      FROM USUARIOS 
        //                     WHERE USUARIO = '{$this->session->userdata('chapa')}'");

        // $nomeimpressora = $sql->row()->grplstemp;
        // return  $nomeimpressora;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////                          PROJETO  CÓDIGOS DE DEFEITOS - SUCATA, CONTROLLER "INT_PCPUSIN/BAIXAREFUGO"                               ////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNA A TABELA PRINCIPAL                              /////////////////////////////
    ///////// CRIADO POR DANIEL                                       /////////////////////////////
    ///////// 21/03/2022                                              /////////////////////////////
    ///////// Revisado:                                               /////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function retornoRegistroRefugo()
    {
        $this->db->where('status <>', 'D');
        $query = $this->db->get("anc");
        return $query->result();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNA A TABELA PRINCIPAL                              /////////////////////////////
    ///////// CRIADO POR DANIEL                                       /////////////////////////////
    ///////// 21/03/2022                                              /////////////////////////////
    ///////// Revisado:                                               /////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function BuscDesvioConc()
    {
        // $db = $this->load->database(getAmbiente(), true);
        // $sql = $db->query("SELECT * FROM ESTMOT WHERE DTMOV > TODAY -1 AND TPDOC = 'DC'");
        // return format_result($sql)->result();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNAR OS DADOS DA TABELA DEFEITOS                    ///////////////////////////
    ///////// CRIADO POR DANIEL                                       ///////////////////////////
    ///////// 21/02/2022                                              ///////////////////////////
    ///////// Revisado:                                               ///////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////
    public function retorno_defeitos()
    {
        // $db = $this->load->database(getAmbiente(), TRUE);
        // $sql = $db->query("SELECT * FROM DEFEITOS WHERE ESTATUS <> 'D' ORDER BY COD_DEFEITO");
        // return format_result($sql)->result();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNAR CENTRO DE CUSTO                    ///////////////////////////
    ///////// CRIADO POR DANIEL                                       ///////////////////////////
    ///////// 21/02/2022                                              ///////////////////////////
    ///////// Revisado:                                               ///////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////
    public function retorno_ccus()
    {
        // $db = $this->load->database(getAmbiente(), TRUE);
        // $sql = $db->query("");
        // return format_result($sql)->result();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    ///////// Objetivo: RETORNAR O "CÓDIGO" PARA CADASTRAR DEFEITOS  ////////////////////////////
    ///////// Criação: 22/02/2022                                    ////////////////////////////
    ///////// Autor: DANIEL                                          ////////////////////////////
    ///////// Revisado:                                              ////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////
    public function BuscaLocal($local)
    {
        // $db = $this->load->database(getAmbiente(), TRUE);
        // $sql = $db->query("SELECT COD_DEFEITO[1,2] || STR(ROUND(COD_DEFEITO[3,4],0) + 1,'00') AS DEFEITO
        //                      FROM DEFEITOS
        //                     WHERE ID_DEFEITOS = (SELECT MAX(ID_DEFEITOS) FROM DEFEITOS WHERE LOCAL = '$local')");

        // if ($sql->num_rows() > 0) {
        //     return $sql->row()->defeito;
        // } else {
        //     $local = utf8_encode($local);
        //     switch ($local) {
        //         case 'FORJARIA':
        //             return 'FO01';
        //             break;
        //         case 'FUNDIÇÃO':
        //             return 'FU01';
        //             break;
        //         case 'TRATAMENTO TÉRMICO':
        //             return 'TT01';
        //             break;
        //         case 'USINAGEM EIXO COMANDO':
        //             return 'UE01';
        //             break;
        //         case 'USINAGEM VOLANTE':
        //             return 'UV01';
        //             break;
        //         case 'USINAGEM CREMALHEIRA':
        //             return 'UC01';
        //             break;
        //         case 'USINAGEM GERAL':
        //             return 'UG01';
        //             break;
        //         case 'RETIFICA':
        //             return 'RT01';
        //             break;
        //         case '4000':
        //             return 'QM01';
        //             break;
        //         case 'SEMI EIXO':
        //             return 'SE01';
        //             break;
        //         case 'SEMI EIXO USINAGEM':
        //             return 'SU01';
        //             break;
        //         case 'SEMI EIXO SEMI USINAGEM':
        //             return 'SSU01';
        //             break;
        //         case 'TAMBOR':
        //             return 'TB01';
        //             break;
        //         case 'PLACA E TAMPA':
        //             return 'PT01';
        //             break;
        //     }
        // }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNAR DADOS PARA EDIÇÃO                             ////////////////////////////
    ///////// CRIADO POR DANIEL                                      ////////////////////////////
    ///////// 21/02/2022                                             ////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////
    public function editarDadosEdit($codDefeitos)
    {
        // $db = $this->load->database(getAmbiente(), TRUE);
        // $sql = $db->query("SELECT * FROM DEFEITOS WHERE ID_DEFEITOS = '$codDefeitos'");
        // return format_result($sql)->result();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////           PROJETO  REGISTROS REFUGO, CONTROLLER "INT_PCPUSIN/REGISTROREFUGO"                 //////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNAR TODOS OS NÚMEROS DOS ALMOXARIFADOS            //////////////////////////////
    ///////// CRIADO POR DANIEL                                      //////////////////////////////
    ///////// 23/03/2022                                             //////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function BuscaNomeSecao()
    {
        $this->db->distinct();
        $this->db->select('local');
        $query = $this->db->get("defeitos");
        return $query->result();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    ////////  RETORNAR ALMOXARIFADOS QUE JÁ FIZERAM RR               //////////////////////////////
    //////// CRIADO POR DANIEL                                       //////////////////////////////
    //////// 23/03/2022                                              //////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function BuscaAlmoxOrig()
    {
        $query = $this->db->get("almoxarifados");
        $sql = $query->result();

        // // $sql = $db->query($sql);

        foreach ($sql as $linha) {
            $retorno[] = array(
                "almorig" => trim($linha->codalm),
                "descricao" => trim(strtoupper(utf8_encode($linha->descricao)))
            );
        }
        return ($retorno);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNAR O NOME DO DOCUMENTO                           /////////////////////////////
    ///////// CRIADO POR DANIEL                                      /////////////////////////////
    ///////// 24/02/2022                                             /////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    public function BuscTpDoc($tpdoc)
    {
        // $db = $this->load->database(getAmbiente(), TRUE);
        // $sql = "SELECT DESCRICAO FROM TIPODOC WHERE ESTATUS <> 'D' AND TPDOC = '$tpdoc' ORDER BY DESCRICAO";
        // $retorno = $db->query($sql);
        // return format_result($retorno)->result();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNAR TODOS OS TIPOS DE DOCUMENTOS                  //////////////////////////////
    ///////// CRIADO POR DANIEL                                      //////////////////////////////
    ///////// 24/02/2022                                             //////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function tipodoc()
    {
        // $db = $this->load->database(getAmbiente(), true);
        // $sql = $db->query("SELECT TPDOC FROM TIPODOC WHERE ESTATUS <> 'D' ORDER BY TPDOC");
        // if ($sql->num_rows() != 0) {
        //     foreach ($sql->result() as $linha) {
        //         $retorno[] = array(
        //             "tpdoc" => trim(strtoupper(utf8_encode($linha->tpdoc))),
        //         );
        //     }
        //     return ($retorno);
        // }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNAR O NOME DO PRODUTO E A UNIDADE MEDIA           //////////////////////////////
    ///////// CRIADO POR DANIEL                                      //////////////////////////////
    ///////// 24/02/2022                                             //////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function buscaNProduto($value)
    {

        // $query = $this->db->get("produtos");
        // $sql = $query->result();

        // Verifica se a ID no banco de dados
        $this->db->where('registro', $value);
        //limita para apenas um regstro    
        $this->db->limit(1);
        //pega os produto
        $query = $this->db->get("produtos");
        //retornamos o produto
        return $query->result();





        // $value = strtoupper($value);
        // $db = $this->load->database(getAmbiente(), TRUE);
        // $sql = "SELECT PROD_DESCRICAO,PROD_CODUNIME FROM PRODNEW WHERE PROD_PRODUTO = '$value'";
        // $retorno = $db->query($sql);
        // return format_result($retorno)->result();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNAR CHAPA                                         /////////////////////////////
    ///////// CRIADO POR DANIEL                                      /////////////////////////////
    ///////// 01/04/2022                                             /////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    public function buscaNChapa($value)
    {
        // $db = $this->load->database(getAmbiente(), TRUE);
        // $sql = "SELECT * FROM FUNCIONARIO WHERE CHAPA = $value AND ESTATUS <> 'D'";

        // $ret = $db->query($sql);

        // if ($ret->num_rows() > 0) {
        //     $db->close();
        //     return 1;
        // } else {
        //     $db->close();
        //     return 0;
        // }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNAR CODIGOS DE DEFEITO                            //////////////////////////////
    ///////// CRIADO POR DANIEL                                      //////////////////////////////
    ///////// 24/02/2022                                             //////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function slLocalRef($value)
    {



        $this->db->select('ID_DEFEITOS,COD_DEFEITO,DESCRICAO');
        // $this->db->select('local', $value);
        $this->db->where('local', $value);
        $query = $this->db->get("defeitos");
        return $query->result();





        // $value = utf8_decode($value);
        // $db = $this->load->database(getAmbiente(), true);
        // $sql = $db->query("SELECT ID_DEFEITOS,COD_DEFEITO,DESCRICAO FROM DEFEITOS WHERE LOCAL = '$value' ORDER BY COD_DEFEITO");
        // if ($sql->num_rows() > 0) {
        //     $retorno = format_result($sql)->result();
        // } else {
        //     $retorno = 0;
        // }
        // $db->close();
        // return $retorno;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNAR CODIGOS DE DEFEITO                            //////////////////////////////
    ///////// CRIADO POR DANIEL                                      //////////////////////////////
    ///////// 24/02/2022                                             //////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function slLocalRef2($value)
    {

        // if (isset($value) == true && $value != '') {
        //     $slLocal = implode("','", $value);
        //     $slLocal = utf8_decode($slLocal);
        // } else {
        //     $slLocal = '';
        // }
        // $db = $this->load->database(getAmbiente(), true);
        // $sql = $db->query("SELECT ID_DEFEITOS,COD_DEFEITO,DESCRICAO FROM DEFEITOS WHERE LOCAL in('$slLocal') ORDER BY COD_DEFEITO");

        // if ($sql->num_rows() > 0) {
        //     $retorno = format_result($sql)->result();
        // } else {
        //     $retorno = 0;
        // }
        // $db->close();
        // return $retorno;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNAR TODOS CENTRO DE CUSTO, CRIADO POR DANIEL      //////////////////////////////
    ///////// CRIADO POR DANIEL                                      //////////////////////////////
    ///////// 31/03/2022                                             //////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function ret_depto()
    {
        $this->db->select('CODCC,DESCRICAO');
        // $this->db->select('local', $value);
        $this->db->where('status <>', 'D');
        $query = $this->db->get("cecusto");
        return $query->result();












        // $db = $this->load->database(getAmbiente(), true);

        // if ($value == 1) {
        //     $sql = $db->query("SELECT CECUS_CODCC AS DEPTO, CECUS_DESCRICAO
        //                          FROM CECUS WHERE CECUS_MAINT <> 'D'");
        // } else {
        //     $sql = $db->query("SELECT CECUS_CODCC AS DEPTO, CECUS_DESCRICAO
        //                          FROM CECUS WHERE CECUS_MAINT <> 'D' AND CECUS_CODCC > 9999");
        // }

        // // A query foi retirada devido as alterações que seram feitas nos centros de custos pelo RH. Ass. Daniel. 12/01/2022
        // //    $sql = $db->query("SELECT CECUS_CODCC AS DEPTO, CECUS_DESCRICAO
        // //    FROM CECUS
        // //   WHERE CECUS_CODCC IN(101, 120, 170, 300, 401,
        // //                        403, 404, 420, 440, 450,
        // //                        470, 540, 601, 640, 657,
        // //                        660, 696, 703, 705, 740,
        // //                        815, 816, 819, 820, 824,
        // //                        825, 832, 850, 871, 872,
        // //                        873, 874, 875, 881, 885)");
        // if ($sql->num_rows() != 0) {
        //     foreach ($sql->result() as $linha) {
        //         $retorno[] = array(
        //             "depto" => strtoupper(utf8_decode(ltrim($linha->depto, '0'))),
        //             "cecus_descricao" => utf8_encode($linha->cecus_descricao)
        //         );
        //     }
        //     return ($retorno);
        // }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    ///////// VALIDA NÚMERO DO DOCUMENTO                             /////////////////////////////
    ///////// CRIADO POR DANIEL                                      /////////////////////////////
    ///////// 05/09/2022                                             /////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    public function ValidaNroDoc($tpdoc)
    {
        // $db = $this->load->database(getAmbiente(), TRUE);
        // $sql = "SELECT * FROM movfabr WHERE NRODOC = $tpdoc and TPDOC in ('RR','E-RR','RET')";
        // $ret = $db->query($sql);

        // if ($ret->num_rows() > 0) {
        //     $db->close();
        //     return 1;
        // } else {
        //     $db->close();
        //     return 0;
        // }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    ///// RETORNAR TABELA PRINCIPAL (RelatorioANC)  Apontamento Não Conformidade   ////////////
    ///// CRIADO POR DANIEL                                                        ////////////
    ///// 24/02/2022                                                               ////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function ret_consulta($input)
    {
        // if (isset($input['slNumeroAlmox']) == true && $input['slNumeroAlmox'] != '') {
        //     $slNumeroAlmox = implode(",", $input['slNumeroAlmox']);
        // }

        // if (isset($input['sltipodoc']) == true && $input['sltipodoc'] != '') {
        //     $sltipodoc = implode("','", $input['sltipodoc']);
        // } else {
        //     $sltipodoc = "RR','RET";
        //     $input['sltipodoc'] = "RR','RET";
        // }

        // if (isset($input['slCeCus']) == true && $input['slCeCus'] != '') {
        //     $slCeCus = implode(",", $input['slCeCus']);
        // }

        // if (isset($input['slLocal']) == true && $input['slLocal'] != '') {
        //     $slLocal = implode("','", $input['slLocal']);
        //     $slLocal = utf8_decode($slLocal);
        // }

        // if (isset($input['slCodrefugo']) == true && $input['slCodrefugo'] != '') {
        //     $slCodrefugo = implode("','", $input['slCodrefugo']);
        //     $slCodrefugo = utf8_decode($slCodrefugo);
        // }

        // $txtoperacao = trim($input['txtOperacao']);

        // $db = $this->load->database(getAmbiente(), TRUE);
        // // retirei o outer do defeitos, pois estava buscando dados sem necessidade "OUTER DEFEITOS C".
        // $sql = "SELECT A.NROOSU,A.DTMOV,A.PRODUTO,A.TPDOC,A.NRODOC,B.ECDAL_CODALM,B.ECDAL_DESCRICAO,C.LOCAL,C.COD_DEFEITO,C.DESCRICAO,
        //                 A.QTDE, D.CECUS_CODCC || ' - ' || D.CECUS_DESCRICAO AS DESCRICAOCUSTO, A.CODOPERACAO, A.CODMAQUI, A.DOCREF, A.OPERADOR,
        //                 E.PROD_DESCRICAO, E.PROD_CODUNIME, F.MOTIVO
        //           FROM MOVFABR A,ECDAL B,  DEFEITOS C, CECUS D, PRODNEW E, OUTER ESTMOT F
        //          WHERE A.ALMORIG = B.ECDAL_CODALM
        //            AND A.CODDEFEITO = C.ID_DEFEITOS
        //            AND A.CODCC = D.CECUS_CODCC
        //            AND A.PRODUTO = PROD_PRODUTO
        //            AND A.NRODOC = F.NRODOC
        //            AND A.TPDOC = F.TPDOC
        //            AND A.OPERACAO in ('-')
        //            AND A.DTMOV BETWEEN  '$input[txtdatainicial]' AND '$input[txtdatafinal]'";
        // isset($input['slCodrefugo']) == true && $input['slCodrefugo'] != ''  ? $sql .= " AND A.coddefeito IN('$slCodrefugo') " : '';
        // isset($input['sltipodoc']) == true && $input['sltipodoc'] != ''  ? $sql .= " AND A.tpdoc IN('$sltipodoc')  " : '';
        // isset($input['slNumeroAlmox']) == true && $input['slNumeroAlmox'] != ''  ? $sql .= " AND A.ALMORIG IN($slNumeroAlmox)  " : '';
        // isset($input['txtProd']) == true && $input['txtProd'] != ''  ? $sql .= " AND A.PRODUTO = " . strtoupper(utf8_decode("'$input[txtProd]'")) . " " : '';
        // isset($input['txtchapaOperador']) == true && $input['txtchapaOperador'] != ''  ? $sql .= " AND A.operador = '$input[txtchapaOperador]'  " : '';
        // isset($input['slCeCus']) == true && $input['slCeCus'] != ''  ? $sql .= " AND A.codcc IN($slCeCus)  " : '';
        // isset($input['txtNMquina']) == true && $input['txtNMquina'] != ''  ? $sql .= " AND A.codmaqui = '$input[txtNMquina]'  " : '';
        // isset($input['txtNDocumento']) == true && $input['txtNDocumento'] != ''  ? $sql .= " AND A.NRODOC = '$input[txtNDocumento]'  " : '';
        // isset($input['txtOS']) == true && $input['txtOS'] != ''  ? $sql .= " AND A.DOCREF = '$input[txtOS]'  " : '';
        // isset($txtoperacao) == true && $txtoperacao != ''  ? $sql .= " AND A.CODOPERACAO = '$txtoperacao'  " : '';
        // isset($slLocal) == true && $slLocal != ''  ? $sql .= " AND C.local IN('$slLocal')" : '';
        // $sql .= " ORDER BY A.ROWID DESC";

        // $ret = $db->query($sql);

        // if ($ret->num_rows() > 0) {
        //     $retorno = format_result($ret)->result();
        // } else {
        //     $retorno = 0;
        // }
        // $db->close();
        // return $retorno;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    ///// RETORNAR TABELA MODAL (RelatorioANC)         ////////////////////////////////////////
    ///// CRIADO POR DANIEL                            ////////////////////////////////////////
    ///// 10/10/2022                                   ////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function retCons($input)
    {
        // if (isset($input['txtNumDoc']) == true && $input['txtNumDoc'] != '') {
        //     $txtNumDoc = $input['txtNumDoc'];
        // }

        // if (isset($input['txtPRodDC']) == true && $input['txtPRodDC'] != '') {
        //     $txtPRodDC = $input['txtPRodDC'];
        // }

        // if (isset($input['txtOrdemProd']) == true && $input['txtOrdemProd'] != '') {
        //     $txtOrdemProd = $input['txtOrdemProd'];
        // }

        // $db = $this->load->database(getAmbiente(), TRUE);

        // $sql = "SELECT A.*,B.PROD_DESCRICAO ,B.PROD_CODUNIME, A.NRODOC || ' - ' || C.NOME AS FUNCIONARIO
        //           FROM ESTMOT A INNER JOIN PRODNEW B ON A.PRODUTO = B.PROD_PRODUTO
        //          INNER JOIN FUNCIONARIO C ON A.NRODOC = C.CHAPA
        //          WHERE A.TPDOC = 'DC'
        //            AND DTMOV BETWEEN  '$input[txtdatainicial]' AND '$input[txtdatafinal]'";
        // isset($input['txtNumDoc']) == true && $input['txtNumDoc'] != ''  ? $sql .= " AND A.NRODOC = $txtNumDoc " : '';
        // isset($input['txtPRodDC']) == true && $input['txtPRodDC'] != ''  ? $sql .= " AND A.PRODUTO = '$txtPRodDC' " : '';
        // isset($input['txtOrdemProd']) == true && $input['txtOrdemProd'] != ''  ? $sql .= " AND A.NUMOS = '$txtOrdemProd' " : '';
        // $sql .= " ORDER BY A.ROWID DESC";

        // $ret = $db->query($sql);

        // if ($ret->num_rows() > 0) {
        //     $retorno = format_result($ret)->result();
        // } else {
        //     $retorno = 0;
        // }
        // $db->close();
        // return $retorno;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNA  REQUISIÇÕES PENDENTES(PROJETO:AprovacaoSolicFilial)/////////////////////////
    ///////// CRIADO POR DANIEL                                      //////////////////////////////
    ///////// 30/05/2022                                             //////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function verifica_req_pendente()
    {
        // $db = $this->load->database(getAmbiente(), true);
        // $sql = $db->query("SELECT * FROM CAB_RET WHERE STATUS = 'P'");

        // if ($sql->num_rows() != 0) {
        //     $retorno = format_result($sql)->result();
        // }
        // $db->close();
        // return ($retorno);
    }

    ////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNA MODAL(PROJETO:AprovacaoSolicFilial)///////////////////////////////
    ///////// CRIADO POR DANIEL                          ///////////////////////////////
    ///////// 31/03/2022                                 ///////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////
    public function exibir_info($value)
    {
        // $db = $this->load->database(getAmbiente(), true);
        // $sql_cab = "SELECT *
        //               FROM CAB_RET A, FUNCIONARIO B
        //              WHERE A.USUCRIA = B.CHAPA
        //                AND RET_ID = $value
        //                AND  A.STATUS = 'P'
        //                AND B.ESTATUS <> 'D'";

        // $ret = $db->query($sql_cab);

        // if ($ret->num_rows() > 0) {

        //     $sql_ret = "SELECT *
        //             FROM DET_RET
        //            WHERE RET_ID = $value
        //              AND STATUS = 'P'
        //         ORDER BY PRODUTO,PRODEXPED";

        //     $sql_result = $db->query($sql_ret);

        //     if ($sql_result->num_rows() > 0) {

        //         $almoxarifado = $ret->row()->almox;

        //         foreach (format_result($sql_result)->result() as $result) {

        //             $sql_proc = "EXECUTE PROCEDURE BUSCA_ULTIMO_MOVMP('$result->prodexped','$almoxarifado',99999999,99999999,0)";
        //             $sql_ret1 = $db->query($sql_proc);

        //             if (intval($sql_ret1->row()->movmp_salmat) != '' || intval($sql_ret1->row()->movmp_salmat) != null) {
        //                 $array['saldo'] = intval($sql_ret1->row()->movmp_salmat);
        //             } else {
        //                 $array['saldo'] = 0;
        //             }

        //             if (trim($result->produto) != '' || trim($result->produto) != null) {
        //                 $array['produto'] = trim($result->produto);
        //             } else {
        //                 $array['produto'] = '';
        //             }

        //             if (trim($result->prodexped) != '' || trim($result->prodexped) != null) {
        //                 $array['prodexped'] = trim($result->prodexped);
        //             } else {
        //                 $array['prodexped'] = '';
        //             }

        //             if (trim($result->qtde) != '' || trim($result->qtde) != null) {
        //                 $array['qtde'] = trim($result->qtde);
        //             } else {
        //                 $array['qtde'] = '';
        //             }

        //             if (trim($result->ret_id) != '' || trim($result->ret_id) != null) {
        //                 $array['ret_id'] = trim($result->ret_id);
        //             } else {
        //                 $array['ret_id'] = '';
        //             }

        //             $retorno['item_req'][] = array_map(null, $array);
        //             //zera erros
        //             error_reporting(0);
        //         }

        //         $retorno['nome_func'] = trim($ret->row()->nome);
        //         $retorno['dtcria'] = trim($ret->row()->dtcria);
        //         $retorno['motivo'] = trim(utf8_encode($ret->row()->motivo));
        //         $retorno['almox'] = trim(utf8_encode($ret->row()->almox));
        //         $retorno['almoxdest'] = trim(utf8_encode($ret->row()->almoxdest));
        //     } else {

        //         $retorno = array(
        //             "cod" => 2,
        //             "msg" => 'NÃO EXISTE DETALHE DE RETRABALHO'
        //         );
        //     }
        // } else {
        //     $retorno = array(
        //         "cod" => 1,
        //         "msg" => 'USUARIO NÃO EXISTE!'
        //     );
        // }
        // $db->close();
        // return $retorno;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNAR OS DETALHES DO LANÇAMENTO                     /////////////////////////////
    ///////// CRIADO POR DANIEL                                      /////////////////////////////
    ///////// 29/09/2022                                             /////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    public function psqNConforme($nrodoc, $produto, $tpdoc)
    {
        // $db = $this->load->database(getAmbiente(), TRUE);
        // $sql = "SELECT A.*,B.MOTIVO
        //           FROM MOVFABR A
        //          LEFT JOIN ESTMOT B ON A.NRODOC = B.NRODOC
        //          WHERE A.PRODUTO = '$produto'
        //            AND A.TPDOC = '$tpdoc'
        //            AND A.NRODOC = $nrodoc
        //            AND A.OPERACAO = '-'";

        // $retorno = $db->query($sql);
        // return format_result($retorno)->result();
        // $db->close();
    }

    //////////////////////////////////////////////////////////////////////////////////////////
    ///// RETORNAR O TIPO DE CODIGO COM O NOME DO CODIGO  ////////////////////////////////////
    ///// CRIADO POR DANIEL                ///////////////////////////////////////////////////
    ///// 03/10/2022                       ///////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    public function BuscLocalCod($cod)
    {
        $this->db->select('local,cod_defeito,descricao');
        $this->db->where('status <>', 'D');
        $this->db->where('cod_defeito', $cod);
        $query = $this->db->get("defeitos");
        return $query->result();


        // $db = $this->load->database(getAmbiente(), TRUE);
        // $sql = "SELECT *
        //           FROM DEFEITOS
        //          WHERE ID_DEFEITOS = $nro";
        // $retorno = $db->query($sql);
        // return format_result($retorno)->result();
        // $db->close();
    }

    //////////////////////////////////////////////////////////////////////////////////////////
    ///// RETORNAR TABELA PRINCIPAL DE RETRABALHO ////////////////////////////////////////////
    ///// CRIADO POR DANIEL                ///////////////////////////////////////////////////
    ///// 18/10/2022                       ///////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    public function retornoRetrabalhos()
    {
        // $db = $this->load->database(getAmbiente(), true);

        // $sql = $db->query("SELECT * 
        //                    FROM MOVFABR
        //                    WHERE TPDOC = 'RET' 
        //                    AND BLOQUEADO = 1 
        //                    AND ALMORIG = 40");

        // if ($sql->num_rows() != 0) {
        //     foreach ($sql->result() as $linha) {

        //         $retorno_saldoRetrabalho = $this->Busca_saldo_retrabalho($db, $linha->produto, 40, $linha->nrodoc);

        //         if ($retorno_saldoRetrabalho > 0) {
        //             $retorno[] = array(
        //                 "produto" => $linha->produto,
        //                 "nrodoc" => $linha->nrodoc,
        //                 "dtmov" => $linha->dtmov,
        //                 "tpdoc" => $linha->tpdoc,
        //                 "almorig" => $linha->almorig,
        //                 "almdest" => $linha->almdest,
        //                 "qtde" => $linha->qtde,
        //                 "saldo" => $linha->saldo,
        //                 "ret_saldo" => $retorno_saldoRetrabalho
        //             );
        //         }
        //     }
        // } else {
        //     $retorno = [];
        // }

        // $db->close();
        // return ($retorno);
    }

    private function Busca_saldo_retrabalho($db, $produto, $almox, $nrodoc)
    {
        // $sql = $db->query("EXECUTE procedure Glb_Sld_ReTrabalho_MovFabr('$produto', $almox, $nrodoc)");

        // if ($sql->row()->erro == 0) {
        //     return ($sql->row()->saldolote);
        // } else {
        //     return 0;
        // }  
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////// RETORNA A TABELA PRINCIPAL                              /////////////////////////////
    ///////// CRIADO POR DANIEL                                       /////////////////////////////
    ///////// 25/04/2022                                              /////////////////////////////
    ///////// Revisado:                                               /////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    public function btnEdit($id)
    {
        $this->db->where('status <>', 'D');
        $this->db->where('id', $id);
        $query = $this->db->get("anc");
        return $query->result();
    }
}
