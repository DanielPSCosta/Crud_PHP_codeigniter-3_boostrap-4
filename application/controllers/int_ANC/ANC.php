<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ANC extends CI_Controller
{
    //Caminho via navegador
    // http://localhost/git/index.php/int_anc/anc
    public function index()
    {
        $this->load->model('int_ANC/M_retorno');
        ////////////////////////////////////////////////////////////////////////////////////////
        ////// RETORNAR TODOS CENTRO DE CUSTO, CRIADO POR DANIEL                           /////
        ////////////////////////////////////////////////////////////////////////////////////////
        $retorno['depto'] = $this->M_retorno->ret_depto();
        ////////////////////////////////////////////////////////////////////////////////////////
        ////// RETORNAR TODOS OS NÚMEROS DOS ALMOXARIFADOS, CRIADO POR DANIEL              /////
        ////////////////////////////////////////////////////////////////////////////////////////
        $retorno['secao'] = $this->M_retorno->BuscaNomeSecao();
        ////////////////////////////////////////////////////////////////////////////////////////
        /////// RETORNAR TODOS OS TIPOS DE DOCUMENTOS, CRIADO POR DANIEL,                ///////
        ////////////////////////////////////////////////////////////////////////////////////////
        $this->load->view('int_ANC/v_registroANC', $retorno);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// RETORNAR ALMOXARIFADO          ////////////////////////////////////////////////////
    /////// CRIADO POR DANIEL              ////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function BuscaAlmoxOrig()
    {
        $this->load->model('int_ANC/M_retorno');
        $retorno = $this->M_retorno->BuscaAlmoxOrig();
        echo json_encode($retorno);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// RETORNAR A TABELA PRINCIPAL    ////////////////////////////////////////////////////
    /////// CRIADO POR DANIEL              ////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function retornoRegistroRefugo()
    {
        $this->load->model('int_ANC/M_retorno');
        $retorno = $this->M_retorno->retornoRegistroRefugo();
        echo json_encode($retorno);
    }


    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// RETORNAR O TABELA PRINCIPAL    ////////////////////////////////////////////////////
    /////// CRIADO POR DANIEL              ////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function btnEdit()
    {
        $id = $this->input->post('id');

        $this->load->model('int_ANC/M_retorno');
        $retorno = $this->M_retorno->btnEdit($id);
        echo json_encode($retorno);
    }

    //////////////////////////////////////////////////////////////////////////////////////////
    ///// RETORNAR O NOME DO PRODUTO E A UNIDADE MEDIA////////////////////////////////////////
    ///// CRIADO POR DANIEL                           ////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    public function buscaNProduto()
    {
        $value = $this->input->post('value');
        $this->load->model('int_ANC/M_retorno');
        $retorno = $this->M_retorno->buscaNProduto($value);
        echo json_encode($retorno);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    ///// RETORNAR O NOME DO PRODUTO E A UNIDADE MEDIA ////////////////////////////////////////
    ///// CRIADO POR DANIEL                            ////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function slLocalRef()
    {
        $value = $this->input->post('value');
        $this->load->model('int_ANC/M_retorno');
        $retorno = $this->M_retorno->slLocalRef($value);
        echo json_encode($retorno);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////
    /////// Objetivo:  BAIXA NO PRODUTO REFUGADO      //////////////////////////////////////////
    /////// Autor: DANIEL                             //////////////////////////////////////////
    /////// Revisado:                                 //////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////
    public function cadastrarRefugo()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txtDataLan', 'DATA LANÇAMENTO', 'required');
        $this->form_validation->set_rules('slNumeroAlmox', 'ALMOXARIFADO', 'required');
        $this->form_validation->set_rules('sltipodoc', 'TIPO DE DOC.', 'required');
        $this->form_validation->set_rules('txtProd', 'PRODUTO', 'required');
        $this->form_validation->set_rules('NumOS', 'N° OP', 'required');
        $this->form_validation->set_rules('txtOperacao', 'OPERAÇÃO', 'required');
        $this->form_validation->set_rules('txtSecao', 'SEÇÃO', 'required');
        $this->form_validation->set_rules('slCodrefugo', 'CÓDIGO DE REFUGO', 'required');
        $this->form_validation->set_rules('txtNMaquina', 'N° MAQUINA', 'required');
        $this->form_validation->set_rules('txtChapaOp', 'CHAPA OPERADOR', 'required');
        $this->form_validation->set_rules('txtCeCus', 'CENTRO CUSTO:', 'required');
        $this->form_validation->set_rules('numQtde', 'QTDE', 'required');
        if ($this->form_validation->run() == FALSE) {
            $erros = array(
                'mensagens' => validation_errors(),
                'cod' => 2
            );
            echo json_encode($erros);
        } else {
            $input = $this->input->post();
            $this->load->model('int_ANC/M_insert');
            $retorno = $this->M_insert->cadastrarRefugo($input);
            echo json_encode($retorno);
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////
    ///// RETORNAR OS DETALHES DO LANÇAMENTO//////////////////////////////////////////////////
    ///// CRIADO POR DANIEL                ///////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    public function btnDeletar()
    {
        $id = $this->input->post('id');

        $this->load->model('int_ANC/M_update');
        $retorno = $this->M_update->btnDeletar($id);
        echo json_encode($retorno);
    }

    //////////////////////////////////////////////////////////////////////////////////////////
    ///// RETORNAR O TIPO DE CODIGO COM O NOME DO CODIGO//////////////////////////////////////
    ///// CRIADO POR DANIEL                ///////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    public function BuscLocalCod()
    {
        $cod = $this->input->post('cod');
        $this->load->model('int_ANC/M_retorno');
        $retorno = $this->M_retorno->BuscLocalCod($cod);
        echo json_encode($retorno);
    }

    public function alterarSaidaDefeito()
    {
        $nro = $this->input->post();

            $this->load->library('form_validation');
            $this->form_validation->set_rules('txtDataLan', 'DATA LANÇAMENTO', 'required');
            $this->form_validation->set_rules('slNumeroAlmox', 'ALMOXARIFADO', 'required');
            $this->form_validation->set_rules('sltipodoc', 'TIPO DE DOC.', 'required');
            $this->form_validation->set_rules('txtProd', 'PRODUTO', 'required');
            $this->form_validation->set_rules('NumOS', 'N° OP', 'required');
            $this->form_validation->set_rules('txtOperacao', 'OPERAÇÃO', 'required');
            $this->form_validation->set_rules('txtSecao', 'SEÇÃO', 'required');
            $this->form_validation->set_rules('slCodrefugo', 'CÓDIGO DE REFUGO', 'required');
            $this->form_validation->set_rules('txtNMaquina', 'N° MAQUINA', 'required');
            $this->form_validation->set_rules('txtChapaOp', 'CHAPA OPERADOR', 'required');
            $this->form_validation->set_rules('txtCeCus', 'CENTRO CUSTO:', 'required');
            $this->form_validation->set_rules('numQtde', 'QTDE', 'required');
            if ($this->form_validation->run() == FALSE) {
                $erros = array(
                    'mensagens' => validation_errors(),
                    'cod' => 4
                );
                echo json_encode($erros);
            } else {
                $this->load->model('int_ANC/M_update');
                $retorno = $this->M_update->alterarSaidaDefeito($nro);
                echo json_encode($retorno);
            }   
    }
}
