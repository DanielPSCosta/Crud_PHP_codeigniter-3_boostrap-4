<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_insert extends CI_Model
{
    /////////////////////////////////////////////////////////////////////////////////////////
    ///////// Objetivo: CADASTRA CÓDIGOS DE DEFEITOS           //////////////////////////////             
    ///////// Criação: 22/02/2022                              //////////////////////////////             
    ///////// Autor: DANIEL                                    //////////////////////////////        
    ///////// Revisado:                                        //////////////////////////////    
    /////////////////////////////////////////////////////////////////////////////////////////
    public function cadastrarDefeito($input)
    {
        $local =  strtoupper(utf8_decode($input['slLocal']));
        $descricao = strtoupper(utf8_decode($input['txtDescricao']));
        $usuchapa = $_SESSION['chapa'];

        $db = $this->load->database(getAmbiente(), TRUE);

        $sql = "INSERT INTO DEFEITOS (local,cod_defeito,descricao,observacao,estatus,usucria)
                VALUES('$local','$input[txtCodDef]','$descricao','','','$usuchapa')";

        $db->query($sql);

        if ($db->trans_status() === false) {
            $db->close();
            return array(
                "cod" => 0,
                "mensagens" => 'Erro ao inserir os dados.',
            );
        } else {
            $db->close();
            return array(
                "cod" => 1,
                "mensagens" => 'Código inserido com sucesso.'
            );
        }
    }

    ////////////////////////////////////////////////////////////////////////////////
    ///////// Objetivo: BAIXA NO PRODUTO REFUGADO  /////////////////////////////////                 
    ///////// Criação: 22/03/2022                  /////////////////////////////////                     
    ///////// Autor: DANIEL                        /////////////////////////////////                     
    ///////// Revisado:                            /////////////////////////////////                     
    /////////////////////////////////////////////////////////////////////////////////
    public function cadastrarSaidaDefeito($input)
    {
        $produto = strtoupper(str_replace('-', '', $input['txtProd']));
        $db = $this->load->database(getAmbiente(), TRUE);
        $chapa = $_SESSION['chapa'];

        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////// Busca data do fechamento do almoxarifado, para não permitir data anterior. ///////
        ////////////////////////////////////////////////////////////////////////////////////////////
        $sqlFecha = "SELECT ECDAL_CODALM,ECDAL_DTFECHMTO FROM ECDAL WHERE ECDAL_CODALM = '$input[slNumeroAlmox]'";
        $retSqlFecha = $db->query($sqlFecha);

        $txtData = $input['txtDataLan'];
        $dataLan = str_replace('-', '', dataInvertida($txtData));

        if ($dataLan < $retSqlFecha->row()->ecdal_dtfechmto) {
            $retorno = array(
                "cod" => 3,
                "mensagens" => "Atenção, Data invalida, almoxarifado fechado."
            );
        } else {
            ////////////////////////////////////////////////////////////////////////////////////////
            ///////// Busca ultimo movimento do estoque.                                  /////////          
            ////////////////////////////////////////////////////////////////////////////////////////
            $sql = "Execute Procedure Busca_Ultimo_MovFabr('$produto','$input[txtDataLan]',32700,'$input[slNumeroAlmox]')";

            $retornoSql = $db->query($sql);

            if ($retornoSql->num_rows() > 0) {

                $Sdofinal = $retornoSql->row()->saldo - $input['numQtde'];

                if ($Sdofinal >= 0) {

                    $db->trans_begin();
                    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    ////   Efetua a movimentação do almoxarifado selecionado para o almoxarifado 0, assim dando baixa no produto com defeito.    ////
                    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    $sqlGrava = "Execute Procedure Bco_Grava_MovFabr('$produto', 
                                                                      '$input[txtDataLan]',
                                                                      '$input[sltipodoc]',
                                                                      $input[txtNumeroDoc],
                                                                      $input[slNumeroAlmox],
                                                                      '-',
                                                                      0,
                                                                      $input[numQtde],
                                                                      $Sdofinal,
                                                                      $chapa,
                                                                      'N',
                                                                      '01/01/1900',
                                                                      '',
                                                                      '',
                                                                      0,
                                                                      $input[NumOS],
                                                                      0,
                                                                      '',
                                                                      0,
                                                                      0,
                                                                      0,
                                                                      0,
                                                                      0,
                                                                      0,
                                                                      0,
                                                                      0,
                                                                      0,
                                                                      $input[txtCeCus],
                                                                      ' ',
                                                                      '$input[txtOperacao]',
                                                                      $input[slCodrefugo],
                                                                      $input[txtChapaOp],
                                                                      $input[txtNMaquina])";

                    $retSqlGrava = $db->query($sqlGrava);

                    if ($retSqlGrava->row()->erro == 0) {
                        ////////////////////////////////////////////////////////////////
                        /////////        Verifica saldo Opu        /////////////////////             
                        ////////////////////////////////////////////////////////////////
                        $sqlProdOpu = "Execute Procedure Pcp_Saldo_Opu ('$produto')";

                        $retSqlProdOpu = $db->query($sqlProdOpu);

                        if ($retSqlProdOpu->row()->nroosu != 0 && $retSqlProdOpu->row()->sldopuosu == 0) {

                            ////////////////////////////////////////////////////////////////
                            ////// Se não houver o produto irá sempre retornar zero.  //////
                            ////////////////////////////////////////////////////////////////
                            $sqlOpu = "UPDATE OPU set ESTATUS = 'F' WHERE NROOPU =  $input[NumOS]";
                            $db->query($sqlOpu);

                            if ($db->trans_status() === false) {
                                $db->trans_rollback();
                                $retorno = array(
                                    "cod" => 2,
                                    "mensagens" => "Erro na atualização da tabela Opu."
                                );
                                $db->close();
                                return $retorno;
                            }
                        }

                        $db->trans_commit();
                        $retorno = array(
                            "cod" => 1,
                            "mensagens" => "Salvo com sucesso."
                        );
                    } else {
                        $db->trans_rollback();
                        $retorno = array(
                            "cod" => 3,
                            "mensagens" => utf8_encode($retSqlGrava->row()->msg . ' - ' . 'PRECISA EMITIR UMA ATP DA QUANTIDADE REQUISITADA')
                        );
                    }
                } else {
                    $retorno = array(
                        "cod" => 3,
                        "mensagens" => "Saldo insuficiente no almoxarifado solicitado"
                    );
                }
            } else {
                $retorno = array(
                    "cod" => 3,
                    "mensagens" => "Atenção, Problemas na leitura de saldo"
                );
            }
        }
        $db->close();
        return $retorno;
    }


    /////////////////////////////////////////////////////////////
    ////// OBJETIVO:  ALTERAR VALORES COM INCONFORMIDADES. ////// 
    ////// CRIAÇÃO: 19/04/2022                             //////
    ////// AUTOR: DANIEL                                   //////
    ////// REVISADO:                                       //////
    /////////////////////////////////////////////////////////////
    public function alterarValores($input)
    {
        if ($input['slAlmEdit'] == 11) {
            $almorig = 61;
            $almdest = 71;
        } else {
            $almorig = 64;
            $almdest = 74;
        }

        $db = $this->load->database(getAmbiente(), TRUE);

        $sqlMovproc = "SELECT * FROM MOVPROC WHERE PRODUTO = '$input[txtProdEdit]' ORDER BY DTMOV DESC LIMIT 1";

        $retsqlMovproc = $db->query($sqlMovproc);

        if ($retsqlMovproc->num_rows() > 0) {

            $PRODUTO  = trim($input['txtProdEdit']);
            $OPERACAO  = $retsqlMovproc->row()->operacao;
            $FASE = $retsqlMovproc->row()->fase;
            $TIPODOC  = trim($retsqlMovproc->row()->tipodoc);
            $NRODOC = $retsqlMovproc->row()->nrodoc;
            $USUCRIA = $_SESSION['chapa'];
            $CORRIDA  = $retsqlMovproc->row()->corrida;
            $DOCREF = $retsqlMovproc->row()->docref;
            $DTMOV = date('Y-m-d') . ' ' . date("H:i:s");

            $TTermico = $input['txtTTermicoEdt'];
            $Retifica = $input['txtretificaEdt'];

            $db->trans_begin();

            $sqlTTermico = "INSERT INTO MOVPROC (PRODUTO, OPERACAO, FASE,
                                         DTMOV, TPMOV, ALMORIG,
                                         ALMDEST, TIPODOC, NRODOC,
                                         QTDE, SALDO, USUCRIA,
                                         DTCRIA, CORRIDA, DOCREF)
                                 VALUES ('$PRODUTO',$OPERACAO,$FASE,
                                         '$DTMOV','+',   $almorig,     
                                         $almdest,     '$TIPODOC',   $NRODOC, 
                                         0,$TTermico,    $USUCRIA,
                                         '$DTMOV','$CORRIDA',$DOCREF)";

            $db->query($sqlTTermico);

            if ($db->trans_status() === true) {

                $sqlRetifica = "INSERT INTO MOVPROC (PRODUTO, OPERACAO, FASE,
                                                    DTMOV, TPMOV, ALMORIG,
                                                    ALMDEST, TIPODOC, NRODOC,
                                                    QTDE, SALDO, USUCRIA,
                                                    DTCRIA, CORRIDA, DOCREF)
                                            VALUES ('$PRODUTO', $OPERACAO, $FASE,
                                                    '$DTMOV', '+', $almdest,     
                                                    $almorig, '$TIPODOC', $NRODOC, 
                                                    0, $Retifica, $USUCRIA,
                                                    '$DTMOV', '$CORRIDA', $DOCREF)";

                $db->query($sqlRetifica);

                if ($db->trans_status() === false) {
                    $db->trans_rollback();
                    $retorno =  array(
                        "cod" => 0,
                        "mensagens" => 'Atenção, favor tentar novamente3.',
                    );
                } else {
                    $db->trans_commit();
                    $retorno =  array(
                        "cod" => 1,
                        "mensagens" => 'Atualização feita com sucesso.'
                    );
                }
            } else {
                $db->trans_rollback();
                $retorno =  array(
                    "cod" => 3,
                    "mensagens" => "Atenção, favor tentar novamente2."
                );
            }
        } else {
            $db->trans_rollback();
            $retorno = array(
                "cod" => 3,
                "mensagens" => "Atenção, favor tentar novamente1."
            );
        }
        $db->close();
        return $retorno;
    }

    public function aprovar_req_item($ret_id, $produto, $almoxOrig, $almoxDest, $tipo)
    {
        //TM DE ACORDO COM O DESTINO
        if ($almoxDest == 109) {
            $tm = 415;
        } else {
            $tm = 406;
        }

        $db = $this->load->database(getAmbiente(), true);

        //INFORMO O PRODUTO, SENDO COMUM OU DE MONTADORA PARA REPOSIÇÃO
        $prodRep = isset($tipo[0]) ? substr(trim($produto), 0, 9) . 'J' : trim($produto);

        //VERIFICAÇÃO DO NÚMERO DE DOCUMENTO
        $sql_consulta_eng = "SELECT * FROM DET_RET, ENG_CADPRD
                                  WHERE RET_ID  = $ret_id
                                    AND	CODPRD  IN ('$produto','" . substr($produto, 1, 8) . "','" . substr($produto, 2, 7) . "')
                                    AND	PRODUTO = '$produto'
                                    AND DET_RET.STATUS = 'P'";

        $sql_consulta = $db->query($sql_consulta_eng);

        if ($sql_consulta->num_rows() > 0) {

            $RetProd_produto = $sql_consulta->row()->prodexped;
            $sql_consulta_prod = "SELECT * FROM PROD WHERE PROD_PRODUTO = '$RetProd_produto'";
            $sql_consultaProd = $db->query($sql_consulta_prod);

            if ($sql_consultaProd->num_rows() > 0) {

                $cod_antigo =  trim($sql_consultaProd->row()->prod_produto);
                $prod_codfam = trim($sql_consultaProd->row()->prod_codfam);

                $buscaMovmpProduto = $sql_consulta->row()->prodexped;
                //VERIFICAÇÃO DO ÚLTIMO REGISTRO NA MOVMP ATRAVÉS DE PROCEDURE
                $sql_procedure = "EXECUTE PROCEDURE BUSCA_ULTIMO_MOVMP ('$buscaMovmpProduto',$almoxOrig,99999999,99999999,0)";

                $exec_proc = $db->query($sql_procedure);

                if ($exec_proc->row()->movmp_salmat > 0) {
                    ///////////////////////////////////////////////////////////////////////////////////////////////
                    ///////////////////////////////////////////////////////////////////////////////////////////////
                    $saldo = intval($exec_proc->row()->movmp_salmat) - intval($sql_consulta->row()->qtde);
                    $vData = $exec_proc->row()->movmp_dtcemis;
                    $dataAtual = str_replace("-", "", dataInvertida(DataServ()));
                    if ($vData != $dataAtual) {
                        $tempo = 10;
                    } else {
                        $tempo = $exec_proc->row()->movmp_horatrans + 10;
                    }

                    ///////////////////////////////////////////////////////////////////////////////////////////////
                    ///////////////////////////////////////////////////////////////////////////////////////////////
                    //OBTENÇÃO DO CÓDIGO DO TIPO DE MOVIMENTAÇÃO
                    $sql_mov = "SELECT * FROM TPMOV WHERE TPMOV_TM = $tm";

                    $ret_sqlMov = $db->query($sql_mov);

                    $inspec_nome = $ret_sqlMov->row()->tpmov_ispecnome;

                    if ($ret_sqlMov->num_rows() > 0) {

                        $retDet_Qtde = $sql_consulta->row()->qtde;
                        $data = str_replace("-", "", dataInvertida(DataServ()));

                        $db->trans_begin();

                        $sql_movmp = "EXECUTE PROCEDURE BCO_GRAVA_MOVMP ('',
                                                                         '',
                                                                         '',
                                                                         $almoxOrig,
                                                                         0,
                                                                         $prod_codfam,
                                                                         0,
                                                                         $data,
                                                                         $data,
                                                                         0,
                                                                         0,
                                                                         0,
                                                                         0,
                                                                         0,
                                                                         $tempo,
                                                                         '$inspec_nome',
                                                                         '',
                                                                         '',
                                                                         $ret_id,
                                                                         0,
                                                                         0,
                                                                         '',
                                                                         '',
                                                                         $retDet_Qtde,
                                                                         0,
                                                                         '$cod_antigo',
                                                                         0,
                                                                         0,
                                                                         0,
                                                                         0,
                                                                         0,
                                                                         0,
                                                                         $saldo,
                                                                         '',
                                                                         $tm,
                                                                         0,
                                                                         '',
                                                                         '',
                                                                         '')";

                        $query_sql_movmp = $db->query($sql_movmp);

                        if ($query_sql_movmp->row()->erro == 0) {
                            $dataSevidor = dataServ();

                            $qtdeMovfab = $sql_consulta->row()->qtde;
                            $chapa = $_SESSION['chapa'];

                            $sql_GravMovfab = "Execute Procedure Bco_Grava_MovFabr ('$prodRep',
                                                                                    '$dataSevidor',
                                                                                    'OSUR',
                                                                                    $ret_id,
                                                                                    $almoxDest,
                                                                                    '+',
                                                                                    $almoxOrig,
                                                                                    $qtdeMovfab,
                                                                                    0,
                                                                                    $chapa,
                                                                                    'N',
                                                                                    '$dataSevidor',
                                                                                    '',
                                                                                    '',
                                                                                    0,
                                                                                    0,
                                                                                    0,
                                                                                    '',
                                                                                    0,
                                                                                    0,
                                                                                    0,
                                                                                    0,
                                                                                    0,
                                                                                    0,
                                                                                    0,
                                                                                    0,
                                                                                    0,
                                                                                    0)";

                            $ret_GravMovfab = $db->query($sql_GravMovfab);

                            if ($ret_GravMovfab->row()->erro == 0) {

                                $prod = $sql_consulta->row()->produto;
                                $prodExped =  $sql_consulta->row()->prodexped;
                                //ATUALIZO O ITEM PARA 'APROVADO' NA TABELA DE DETALHE
                                $sql_atualiza_det = "UPDATE DET_RET
			                             			    SET STATUS = ''
			                             			  WHERE RET_ID = $ret_id
			                             			    AND PRODUTO = '$prod' 
			                             			    AND PRODEXPED = '$prodExped'
			                             			    AND STATUS = 'P'";

                                $db->query($sql_atualiza_det);

                                if ($db->trans_status() === TRUE) {

                                    //VERIFICO SE AINDA EXISTE ALGUM ITEM PENDENTE NA TABELA DE DETALHE
                                    $sql_verifica_det = "SELECT *
                                                           FROM DET_RET
                                                          WHERE RET_ID = $ret_id
                                                            AND STATUS = 'P'";

                                    $ret_verifica_det = $db->query($sql_verifica_det);

                                    if ($ret_verifica_det->num_rows() == 0) {
                                        //SE NÃO EXISTIR MAIS NENHUM ITEM DE DETALHE, A TABELA DE CABEÇALHO É ATUALIZADA
                                        $sql_atualiza_cab = "UPDATE	CAB_RET
                                                                SET STATUS = ''
                                                              WHERE RET_ID = $ret_id
                                                                AND STATUS = 'P'";

                                        $db->query($sql_atualiza_cab);

                                        if ($db->trans_status() === TRUE) {
                                            $db->trans_commit();
                                            $retorno = array(
                                                "cod" => 1,
                                                "msg" => 'Requisição Aprovada com Sucesso.'
                                            );
                                        } else {
                                            $db->trans_rollback();
                                            $retorno = array(
                                                "cod" => 3,
                                                "msg" => 'Erro na aprovação do item'
                                            );
                                        }
                                    } else {
                                        $db->trans_commit();
                                        $retorno = array(
                                            "cod" => 1,
                                            "msg" => 'Requisição Aprovada com Sucesso.'
                                        );
                                    }
                                } else {
                                    $db->trans_rollback();
                                    $retorno = array(
                                        "cod" => 3,
                                        "msg" => 'Erro na aprovação do item'
                                    );
                                }
                            } else {
                                $db->trans_rollback();
                                $retorno = array(
                                    "cod" => 3,
                                    "msg" => utf8_encode($ret_GravMovfab->row()->msg)
                                );
                            }
                        } else {
                            $db->trans_rollback();
                            $retorno = array(
                                "cod" => 3,
                                "msg" => $query_sql_movmp->row()->msg
                            );
                        }
                    } else {
                        $retorno = array(
                            "cod" => 3,
                            "msg" => 'Código do tipo de movimentação não encontrado!'
                        );
                    }
                } else {
                    $retorno = array(
                        "cod" => 3,
                        "msg" => 'Saldo zerado!'
                    );
                }
            } else {
                $retorno = array(
                    "cod" => 3,
                    "msg" => 'Produto não cadastrado!'
                );
            }
        } else {
            $retorno = array(
                "cod" => 3,
                "msg" => 'Número de documento não existe!'
            );
        }
        $db->close();
        return $retorno;
    }


    function reprovar_req_item($ret_id, $produto)
    {
        $db = $this->load->database(getAmbiente(), TRUE);
        $db->trans_begin();

        $sql = "UPDATE DET_RET 
            SET STATUS = 'D'
                 WHERE 	RET_ID = $ret_id
                   AND 	PRODUTO = '$produto'
                   AND 	STATUS = 'P'";

        $db->query($sql);

        if ($db->trans_status() === TRUE) {
            $sql_det = "SELECT *
                      FROM DET_RET
                     WHERE RET_ID = $ret_id
                       AND STATUS = 'P'";

            $sql_det = $db->query($sql_det);

            if ($sql_det->num_rows() == 0) {

                $sql_cab = "UPDATE CAB_RET
                               SET STATUS = 'D'
                             WHERE RET_ID = $ret_id
                               AND STATUS = 'P'";

                $db->query($sql_cab);

                if ($db->trans_status() === TRUE) {
                    $db->trans_commit();
                    $retorno = array(
                        "cod" => 1,
                        "msg" => "Item cancelado"
                    );
                } else {
                    $db->trans_rollback();
                    $retorno = array(
                        "cod" => 0,
                        "msg" => "Nada contrado"
                    );
                }
            } else {
                $db->trans_commit();
                $retorno = array(
                    "cod" => 1,
                    "msg" => "Item cancelado"
                );
            }
        } else {
            $db->trans_rollback();
            $retorno = array(
                "cod" => 0,
                "msg" => "Item não encontrado"
            );
        }

        $db->close();
        return $retorno;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////            PROJETO DE NÃO CONFORMIDADE               //////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function cadastraRetrabalho($input)
    {
        $observao = utf8_decode(strtoupper($input['txtobservacao']));
        $produto = strtoupper(str_replace('-', '', $input['txtProd']));
        $db = $this->load->database(getAmbiente(), TRUE);
        $chapa = $_SESSION['chapa'];

        if (isset($input['slCodrefugo']) == true && $input['slCodrefugo'] != '') {
            $input['slCodrefugo'] = $input['slCodrefugo'];
        } else {
            $input['slCodrefugo'] = 0;
        }

        if (isset($input['txtobservacao']) == true && $input['txtobservacao'] != '') {
            $input['txtobservacao'] = strtoupper($input['txtobservacao']);
        } else {
            $input['txtobservacao'] = '';
        }

        $db->trans_begin();



        if ($input['txtNumeroDoc'] == '') {
            //busca numero do codigo de barra
            $sql = "SELECT DOCUM_NUMOE + 1 AS CODIGO FROM DOCUM WHERE DOCUM_ISPECNOME = 'RR'";
            $ret = $db->query($sql);

            if ($ret->num_rows() > 0) {
                $ret = $ret->row();
                //atualiza tabela que tem o codigo de barras para o codigo de barra assim não se repetir em outro local
                $sql = "UPDATE DOCUM SET DOCUM_NUMOE = $ret->codigo WHERE DOCUM_ISPECNOME = 'RR'";

                $retorno2 = $db->query($sql);

                if ($retorno2 > 0) {

                    $input['txtNumeroDoc'] = $ret->codigo;
                } else {
                    $db->trans_rollback();
                    $retorno = array(
                        "cod" => 0,
                        "msg" => "Favor tentar daqui alguns minutos"
                    );
                }
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////// OBJETIVO: EFETUA A MOVIMENTAÇÃO DO ALMOXARIFADO SELECIONADO PARA O ALMOXARIFADO 40 "O ALMOXARIFADO 40 É O DE RETRABALHO".  ////// 
        ////// CRIAÇÃO: 19/09/2022                                                                                                        //////
        ////// AUTOR: DANIEL                                                                                                              //////
        ////// REVISADO:                                                                                                                  //////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $sqlGrava = "Execute Procedure Bco_Grava_MovFabr('$produto', 
                                                         '$input[txtDataLan]',
                                                         '$input[sltipodoc]',
                                                         $input[txtNumeroDoc],
                                                         $input[slNumeroAlmox],
                                                         '-',
                                                         40,
                                                         $input[numQtde],
                                                         0,
                                                         $chapa,
                                                         'N',
                                                         '01/01/1900',
                                                         '',
                                                         '',
                                                         $input[txtNumeroDoc],
                                                         $input[NumOS],
                                                         0,
                                                         '',
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         0,
                                                         $input[txtCeCus],
                                                         ' ',
                                                         '$input[txtOperacao]',
                                                         $input[slCodrefugo],
                                                         $input[txtChapaOp],
                                                         $input[txtNMaquina])";

        $retSqlGrava = $db->query($sqlGrava);

        if ($retSqlGrava->row()->erro == 0) {
            $sqlupdate = "UPDATE MOVFABR
                             SET BLOQUEADO = 1
                           WHERE NRODOC = $input[txtNumeroDoc]
                             AND ALMORIG = 40
                             AND TPDOC = '$input[sltipodoc]'
                             AND PRODUTO = '$produto'";

            $db->query($sqlupdate);

            if ($db->trans_status() === TRUE) {

                $sqlinsert = "SELECT *
                                FROM MOVFABR 
                               WHERE PRODUTO = '$produto'
                                 AND TPDOC = '$input[sltipodoc]'
                                 AND NRODOC = $input[txtNumeroDoc]
                                 AND OPERACAO = '-'";

                $sqlinsertResult = $db->query($sqlinsert);

                $produtoMovFabr =  $sqlinsertResult->row()->produto;
                $dataMovFabr = formatarData($sqlinsertResult->row()->dtmov);
                $SegMovFabr  = $sqlinsertResult->row()->seqorig;
                $tpdocMovFabr = $sqlinsertResult->row()->tpdoc;
                $nrodocMovFabr = $sqlinsertResult->row()->nrodoc;

                if ($sqlinsertResult->num_rows() > 0) {

                    $sqlinsertOBS = "Execute Procedure Bco_Grava_MotEstorno ('$produtoMovFabr', 
                                                                             '$dataMovFabr', 
                                                                             $SegMovFabr, 
                                                                             '$tpdocMovFabr', 
                                                                             $nrodocMovFabr, 
                                                                             '$observao',
                                                                             $input[numQtde], 
                                                                             $input[NumOS])";

                    $sqlinsertResultOBS = $db->query($sqlinsertOBS);

                    if ($sqlinsertResultOBS->row()->erro == 0) {
                        $db->trans_commit();
                        $retorno = array(
                            "cod" => 1,
                            "mensagens" => "Salvo com sucesso."
                        );
                    } else {
                        $db->trans_rollback();
                        $retorno = array(
                            "cod" => 3,
                            "mensagens" => utf8_encode($retSqlGrava->row()->msg)
                        );
                    }
                } else {
                    $db->trans_rollback();
                    $retorno = array(
                        "cod" => 0,
                        "msg" => "Favor tentar daqui alguns minutos"
                    );
                }
            } else {
                $db->trans_rollback();
                $retorno = array(
                    "cod" => 0,
                    "msg" => "Favor tentar daqui alguns minutos"
                );
            }
        } else {
            $db->trans_rollback();
            $retorno = array(
                "cod" => 3,
                "mensagens" => utf8_encode($retSqlGrava->row()->msg)
            );
        }

        $db->close();
        return $retorno;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////// Objetivo: BAIXA NO PRODUTO REFUGADO, ENCAMINHA O PRODUTO PARA O ALMOXARIFADO 0  /////////////////////////////////                 
    ///////// Criação: 19/09/2022                                                             /////////////////////////////////                     
    ///////// Autor: DANIEL                                                                   /////////////////////////////////                     
    ///////// Revisado:                                                                       /////////////////////////////////                     
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function cadastrarRefugo($input)
    {
        $this->db->select('nrodoc');
        $this->db->where('tpdoc', $input["sltipodoc"]);
        $query = $this->db->get("docum");
        $numeroDoc = $query->result();

        $numeroDoc = $numeroDoc['0']->nrodoc;

        $numeroDocUso = $numeroDoc + 1;

        $this->db->set('nrodoc', $numeroDocUso);
        $this->db->where('tpdoc', $input["sltipodoc"]);
        $retornoDocum =  $this->db->update('docum');

        if ($retornoDocum == true) {

            $date = date_create($input["txtDataLan"]);
            $dateformatada =  date_format($date, 'Y-m-d');
           
            $dados = array(
                'dtbaixa'   => $dateformatada,
                'produto'   =>  $input["txtProd"],
                'tpdoc'   =>  $input["sltipodoc"],
                'ndoc'   =>  $numeroDocUso,
                'almox'   =>  $input["slNumeroAlmox"],
                'cod'   =>  $input["slCodrefugo"],
                'qtde'   =>  $input["numQtde"],
                'observacao'   =>  $input["txtobservacao"],
                'cecus'   =>  $input["txtCeCus"],
                'chapaop'   =>  $input["txtChapaOp"],
                'nmaquina'   =>  $input["txtNMaquina"],
                'operacao'   =>  $input["txtOperacao"],
                'OrdProd'   =>  $input["NumOS"]
            );

            $retorno = $this->db->insert('anc', $dados);

            if ($retorno == false) {
                $msg = array(
                    'cod' => '2',
                    'mensagens' => 'Erro ao realizar o lançamento, verifique!'
                );
            } else {
                $msg = array(
                    'cod' => '1',
                    'mensagens' => 'Lançamento realizado com sucesso!'
                );
            }
        }else{
            $msg = array(
                'cod' => '2',
                'mensagens' => 'Erro no número do documento!'
            ); 
        }
        return $msg;

    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////            PROJETO DE NÃO CONFORMIDADE               //////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function cadastrarDesvioConc($input)
    {


        // $usuario = $this->session->userdata('chapa');

        // $observao = strtoupper($input['txtobservacao']);
        // $db = $this->load->database(getAmbiente(), TRUE);

        // $sql = "SELECT * FROM ESTMOT WHERE  SEQ = '$input[txtNumeroDoc]' AND PRODUTO = '$input[txtProd]'";

        // $resultSql = $db->query($sql);

        // if ($resultSql->num_rows() > 0) {
        //     $retorno = array(
        //         "cod" => 6,
        //         "mensagens" => 'NÚMERO DE DOCUMENTO E PRODUTO JÁ INSERIDOS NO DESVIO DE CONCESSÃO.'
        //     );
        // } else {

        //     $db->trans_begin();

        //     if ($input['txtNumeroDoc'] == '') {
        //         //busca numero do codigo de barra
        //         $sql = "SELECT DOCUM_NUMOE + 1 AS CODIGO FROM DOCUM WHERE DOCUM_ISPECNOME = 'RR'";
        //         $ret = $db->query($sql);

        //         if ($ret->num_rows() > 0) {
        //             $ret = $ret->row();
        //             //atualiza tabela que tem o codigo de barras para o codigo de barra assim não se repetir em outro local
        //             $sql = "UPDATE DOCUM SET DOCUM_NUMOE = $ret->codigo WHERE DOCUM_ISPECNOME = 'RR'";

        //             $retorno2 = $db->query($sql);

        //             if ($retorno2 > 0) {

        //                 $input['txtNumeroDoc'] = $ret->codigo;
        //             } else {
        //                 $db->trans_rollback();
        //                 $retorno = array(
        //                     "cod" => 0,
        //                     "msg" => "Favor tentar daqui alguns minutos"
        //                 );
        //             }
        //         }
        //     }

        //     $sqlinsertOBS = "Execute Procedure Bco_Grava_MotEstorno ('$input[txtProd]', 
        //                                                              '$input[txtDataLan]', 
        //                                                              $input[txtNumeroDoc], 
        //                                                              '$input[sltipodoc]', 
        //                                                              $usuario, 
        //                                                              '$observao',
        //                                                              $input[numQtde], 
        //                                                              $input[NumOS])";

        //     $sqlinsertResultOBS = $db->query(utf8_decode($sqlinsertOBS));

        //     if ($sqlinsertResultOBS->row()->erro == 0) {
        //         $db->trans_commit();
        //         $retorno = array(
        //             "cod" => 1,
        //             "mensagens" => "Salvo com sucesso."
        //         );
        //     } else {
        //         $db->trans_rollback();
        //         $retorno = array(
        //             "cod" => 6,
        //             "mensagens" => utf8_encode($sqlinsertResultOBS->row()->msg)
        //         );
        //     }
        // }

        // $db->close();
        // return $retorno;
    }

    public function liberaSaldoRetrabalho($input)
    {
        $input['txtServExecute'] = strtoupper(utf8_decode($input['txtServExecute']));

        // verificar a inserção do "serviço executado", "quantidade liberada" e "quantidade para refugo"
        // procedure não tem os campospedir para o Bras incluir
        $db = $this->load->database(getAmbiente(), TRUE);
        $db->trans_begin();

        //busca numero do codigo de barra
        $sql = "SELECT DOCUM_NUMOE + 1 AS CODIGO FROM DOCUM WHERE DOCUM_ISPECNOME = 'PCPAT'";

        $ret = $db->query($sql);

        if ($ret->num_rows() > 0) {
            $ret = $ret->row();
            //atualiza tabela que tem o codigo de barras para o codigo de barra assim não se repetir em outro local
            $sql = "UPDATE DOCUM SET DOCUM_NUMOE = $ret->codigo WHERE DOCUM_ISPECNOME = 'PCPAT'";

            $retorno2 = $db->query($sql);

            if ($retorno2 > 0) {

                $chapa = $_SESSION['chapa'];
                $data = dataServ();

                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ////   Efetua a movimentação do almoxarifado selecionado para o almoxarifado 0, assim dando baixa no produto com defeito.    ////
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $sqlGrava = "Execute Procedure Bco_Grava_MovFabr('$input[txtProd]', 
                                                                 '$data',
                                                                 'ATR',
                                                                 $ret->codigo,
                                                                 40,
                                                                 '-',
                                                                 $input[slNumeroAlmox],
                                                                 $input[QtdeLib],
                                                                 0,
                                                                 $chapa,
                                                                 'N',
                                                                 '01/01/1900',
                                                                 '',
                                                                 '',
                                                                 $input[txtNumeroDoc],
                                                                 0,
                                                                 0,
                                                                 '',
                                                                 0,
                                                                 0,
                                                                 0,
                                                                 0,
                                                                 0,
                                                                 0,
                                                                 0,
                                                                 0,
                                                                 0,
                                                                 0,
                                                                 '$input[txtServExecute]')";

                $retSqlGrava = $db->query($sqlGrava);

                if ($retSqlGrava->row()->erro == 0) {
                    $db->trans_commit();
                    $retorno = array(
                        "cod" => 1,
                        "mensagens" => "Salvo com sucesso."
                    );
                } else {
                    $db->trans_rollback();
                    $retorno = array(
                        "cod" => 2,
                        "mensagens" => utf8_encode($retSqlGrava->row()->msg)
                    );
                }
            } else {
                $db->trans_rollback();
                $msg = array(
                    'cod' => 2,
                    'msg' => ' Erro ao receber, verifique !'
                );
            }
        } else {

            $db->trans_rollback();
            $msg = array(
                'cod' => 2,
                'msg' => ' Erro ao receber, verifique !'
            );
        }
        $db->close();
        return $retorno;
    }
}
