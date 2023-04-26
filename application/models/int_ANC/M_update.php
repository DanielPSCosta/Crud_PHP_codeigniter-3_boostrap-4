<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_update extends CI_Model
{
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////// Objetivo: EDITA A DESCRIÇÃO DO CÓDIGO DE DEFEITOS     ///////////////////////////
    ///////// Criação: 22/02/2022                                   ///////////////////////////
    ///////// Autor: DANIEL                                         ///////////////////////////
    ///////// Revisado:                                             ///////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function editarCodDef($input)
    {
        // $descricao = strtoupper(utf8_decode($input['txtDescricao']));

        // $db = $this->load->database(getAmbiente(), TRUE);
        // $db->trans_begin();
        // $sql = "UPDATE defeitos SET descricao = '$descricao' WHERE id_defeitos = '$input[ipt_id_alterar]'";

        // $db->query($sql);

        // if ($db->trans_status() === FALSE) {
        //     $db->trans_rollback();
        //     return array(
        //         "cod" => 2,
        //         "mensagens" => 'ERRO AO ALTERAR O DADOS',
        //     );
        // } else {
        //     $db->trans_commit();
        //     return array(
        //         "cod" => 1,
        //         "mensagens" => 'DADOS ALTERADOS COM SUCESSO',
        //     );
        // }
    }
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////// Objetivo: EXCLUI CÓDIGO DE  DEFEITOS          ///////////////////////////////////
    ///////// Criação: 22/02/2022                           ///////////////////////////////////
    ///////// Autor: DANIEL                                 ///////////////////////////////////
    ///////// Revisado:                                     ///////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function excluirItem($codDefeitos)
    {
        // $db = $this->load->database(getAmbiente(), TRUE);
        // $db->trans_begin();
        // $sql = "UPDATE defeitos SET estatus = 'D' WHERE id_defeitos = '$codDefeitos'";

        // $db->query($sql);

        // if ($db->trans_status() === FALSE) {
        //     $db->trans_rollback();
        //     return array(
        //         "cod" => 2,
        //         "mensagens" => 'ERRO AO DELETAR O DADOS',
        //     );
        // } else {
        //     $db->trans_commit();
        //     return array(
        //         "cod" => 1,
        //         "mensagens" => 'DELETADO COM SUCESSO',
        //     );
        // }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////// Objetivo: EDITA ITENS DA CONTROLE DE SAIDE DE NÃO CONFORMIDADE  /////////////////
    ///////// Criação: 04/09/2022                                   ///////////////////////////
    ///////// Autor: DANIEL                                         ///////////////////////////
    ///////// Revisado:                                             ///////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function alterarSaidaDefeito($input)
    {
        $dados = array(
            'operacao'   =>  $input["txtOperacao"],
            'observacao'   =>  $input["txtobservacao"],
            'cod'   =>  $input["slCodrefugo"],
            'cecus'   =>  $input["txtCeCus"],
            'chapaop'   =>  $input["txtChapaOp"],
            'nmaquina'   =>  $input["txtNMaquina"],
        );

        $this->db->set($dados);
        $this->db->where('ndoc', $input["txtNumeroDoc"]);
        $AncUpdate =  $this->db->update('anc');


        if ($AncUpdate == true) {
            $msg = array(
                'cod' => '1',
                'mensagens' => 'Atualizado com sucesso!'
            );
        } else {
            $msg = array(
                'cod' => '2',
                'mensagens' => 'Erro ao atualizar!'
            );
        }
        return $msg;
       
        // var_dump($input);
        // exit();
    }

    function btnDeletar($id)
    {

        $this->db->set('status', 'D');
        $this->db->where('id', $id);
        $retornoDocum =  $this->db->update('anc');

        if ($retornoDocum == true) {
            $msg = array(
                'cod' => '1',
                'mensagens' => 'Deletado com sucesso!'
            );
        } else {
            $msg = array(
                'cod' => '2',
                'mensagens' => 'Erro ao deletar!'
            );
        }
        return $msg;
    }
}
