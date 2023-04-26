<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Cinpal - Intranet</title>

    <script src="https://kit.fontawesome.com/775fd40529.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="//code.jquery.com/jquery-3.6.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- this should go after your </body> -->
    <link rel="stylesheet" type="text/css" href="/datapicker/jquery.datetimepicker.css" />
    <script src="/datapicker/jquery.js"></script>
    <script src="/build/jquery.datetimepicker.full.min.js"></script>

    <script>
        //////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: CARREGA ITENS ASSIM QUE A TELA É INICIADA  ////////////////             
        //////// Autor: DANIEL                                    ////////////////////        
        //////// Revisado:                                        ////////////////////        
        //////////////////////////////////////////////////////////////////////////////
        $(document).ready(function() {
            CarregaItens()
        });

        function blockEvent(e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        }

        function alterarSaidaDefeito() {
            $('#txtDataLan').prop('readonly', false);
            $('#slNumeroAlmox').prop('disabled', false);
            $('#sltipodoc').prop('disabled', false);
            $('#txtProd').prop('readonly', false);
            $('#NumOS').prop('disabled', false);
            $('#numQtde').prop('disabled', false);

            $.ajax({
                url: "http://localhost/git/index.php/INT_ANC/ANC/alterarSaidaDefeito",
                type: "POST",
                dataType: 'json',
                data: $('#frmConRef').serialize(),
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: "http://localhost/git/img/loading.gif",
                        showConfirmButton: false
                    });
                },
                error: function(data_error) {
                    sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                },
                success: function(result) {

                    if (result['cod'] == 1) {
                        $("#tbl_Defeitos").bootstrapTable('refresh');
                        $('#txtDataLan').prop('readonly', true);
                        $('#slNumeroAlmox').prop('disabled', true);
                        $('#sltipodoc').prop('disabled', true);
                        $('#txtProd').prop('readonly', true);
                        $('#NumOS').prop('disabled', true);
                        $('#numQtde').prop('disabled', true);
                        sweetAlert('OK!', '' + result.mensagens + '', 'success');
                        $('#cad_defeitos').modal('hide');

                    } else if (result['cod'] == 4) {
                        $('#txtDataLan').prop('readonly', true);
                        $('#slNumeroAlmox').prop('disabled', true);
                        $('#sltipodoc').prop('disabled', true);
                        $('#txtProd').prop('readonly', true);
                        $('#NumOS').prop('disabled', true);
                        $('#numQtde').prop('disabled', true);

                        swal({
                            timer: 1000,
                            title: "Aguarde!",
                            text: "Cadastrando os dados...",
                            imageUrl: "http://localhost/git/img/loading.gif",
                            button: false,
                        });
                        $('#msg').html(result.mensagens);
                        $('#alert').removeClass('d-none');
                    } else {
                        $('#txtDataLan').prop('readonly', true);
                        $('#slNumeroAlmox').prop('disabled', true);
                        $('#sltipodoc').prop('disabled', true);
                        $('#txtProd').prop('readonly', true);
                        $('#NumOS').prop('disabled', true);
                        $('#numQtde').prop('disabled', true);

                        sweetAlert('Oops...!', '' + result.mensagens + '', 'info');
                    }
                },
            });
        }


        function tipodoc(value) {
            if (value == 'RET') {

                $('#txtSecao').prop('disabled', false);
                $('#txtSecao').selectpicker('refresh');
                $('#slCodrefugo').prop('disabled', false);
                $('#slCodrefugo').selectpicker('refresh');
                $('#NumOS').prop('disabled', false);
                $('#txtNMaquina').prop('disabled', false);
                $('#txtChapaOp').prop('disabled', false);
                $('#txtCeCus').prop('disabled', false);
                $('#numQtde').prop('disabled', false);
                $('#txtOperacao').prop('disabled', false);
                $('#slNumeroAlmox').prop('disabled', false);
                $('#slNumeroAlmox').selectpicker('refresh');
                $('#txtCeCus').prop('disabled', false);
                $('#txtCeCus').selectpicker('refresh');

            } else if (value == 'RR') {

                $('#txtSecao').prop('disabled', false);
                $('#txtSecao').selectpicker('refresh');
                $('#slCodrefugo').prop('disabled', false);
                $('#slCodrefugo').selectpicker('refresh');
                $('#slNumeroAlmox').prop('disabled', false);
                $('#slNumeroAlmox').selectpicker('refresh');
                $('#txtCeCus').prop('disabled', false);
                $('#txtCeCus').selectpicker('refresh');
                $('#NumOS').prop('disabled', false);
                $('#txtNMaquina').prop('disabled', false);
                $('#txtChapaOp').prop('disabled', false);
                $('#txtCeCus').prop('disabled', false);
                $('#numQtde').prop('disabled', false);
                $('#txtOperacao').prop('disabled', false);
            } else {
                $('#txtSecao').val('');
                $('#txtSecao').prop('disabled', true);
                $('#txtSecao').selectpicker('refresh');
                $('#slCodrefugo').val('');
                $('#slCodrefugo').prop('disabled', true);
                $('#slCodrefugo').selectpicker('refresh');
                $('#slNumeroAlmox').val('');
                $('#slNumeroAlmox').prop('disabled', true);
                $('#slNumeroAlmox').selectpicker('refresh');
                $('#txtCeCus').val('');
                $('#txtCeCus').prop('disabled', true);
                $('#txtCeCus').selectpicker('refresh');
                $('#txtNMaquina').prop('disabled', true);
                $('#txtChapaOp').prop('disabled', true);
                $('#txtCeCus').prop('disabled', true);
                $('#txtOperacao').prop('disabled', true);
                $('#txtChapaOp').val('');
                $('#txtNMaquina').val('');
                $('#txtOperacao').val('');
            }
        }

        function horacr(value) {
            if (value.length == 6) {
                var hora = value.split('', 6);
                return hora[0] + hora[1] + ':' + hora[2] + hora[3] + ':' + hora[4] + hora[5];
            } else {
                var hora = value.split('', 5);
                return '0' + hora[0] + ':' + hora[1] + hora[2] + ':' + hora[3] + hora[4];
            }
        }

        //////////////////////////////////////////////////////////////////////////////
        ///////////////          EDITA QUANTIDADE(TIRA O ".000")        //////////////
        //////////////////////////////////////////////////////////////////////////////
        function editQtde(value) {
            return parseInt(value);
        }

        //////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: ABRE A MODAL PARA CADASTRAR UM DEFEITO ////////////////////             
        //////// Autor: DANIEL                                    ////////////////////        
        //////// Revisado:                                        ////////////////////        
        //////////////////////////////////////////////////////////////////////////////
        function modalCadDefeito() {
            $('#txtDataLan').prop('readonly', false);
            $('#slNumeroAlmox').prop('disabled', false);
            $('#sltipodoc').prop('disabled', false);
            $('#txtProd').prop('readonly', false);
            $('#NumOS').prop('disabled', false);
            $('#numQtde').prop('disabled', false);

            $('#limpartabPrinc').removeClass('d-none');
            $('#SalvtabPrinc').removeClass('d-none');

            $('#AlttabPrinc').addClass('d-none');
            $('#limpartabEdit').addClass('d-none');
            limpar();
            $('#cad_defeitos').modal('show');
        }

        //////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: CARREGA ITENS NA MODAL                 ////////////////////             
        //////// Autor: DANIEL                                    ////////////////////        
        //////// Revisado:                                        ////////////////////        
        //////////////////////////////////////////////////////////////////////////////
        function CarregaItens() {
            $.ajax({
                url: "http://localhost/git/index.php/INT_ANC/ANC/BuscaAlmoxOrig",
                type: "POST",
                dataType: 'json',
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: "http://localhost/git/img/loading.gif",
                        button: false,
                    });
                },
                error: function(data_error) {
                    sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                },
                success: function(result) {
                    swal({
                        timer: 1,
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: "http://localhost/git/img/loading.gif",
                        button: false,
                    });

                    $('#txtSecao').attr('disabled', false);
                    $('#AlttabPrinc').addClass('d-none');
                    $('#limpartabPrinc').removeClass('d-none');
                    $('#SalvtabPrinc').removeClass('d-none');
                    $('#slNumeroAlmox').html('');
                    $('#slNumeroAlmox').append('<option value=""> SELECIONE </option>');

                    $.each(result, function(index, value) {
                        $('#slNumeroAlmox').append('<option class="text-uppercase" value="' + value['almorig'] + '">' + value['almorig'] + ' - ' + value['descricao'] + '</option>');
                    });
                },
            });
        }

        //////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: LIMPA A MODAL NO ESTADO DE CADASTRO   /////////////////////                       
        //////// Autor: DANIEL                                   /////////////////////      
        //////// Revisado:                                       /////////////////////      
        //////////////////////////////////////////////////////////////////////////////
        function limpar() {
            $('#frmConRef')[0].reset();
            $('#alert').addClass('d-none')
            $('#slCodrefugo').prop('disabled', true);
            $('#slCodrefugo').html('');
            $('#slCodrefugo').append('<option value=""> SELECIONE </option>');
            $('#txtmotivorefugo').val('');
            $('#NumOS').prop('disabled', false);
            $('#txtNMaquina').prop('disabled', false);
            $('#txtChapaOp').prop('disabled', false);
            $('#txtCeCus').prop('disabled', false);
            $('#numQtde').prop('disabled', false);
            $('#txtOperacao').prop('disabled', false);

        }

        //////////////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: BUSCA O NOME DO PRODUTO             ///////////////////////////////                 
        //////// Autor: DANIEL                                 ///////////////////////////////             
        //////// Revisado:                                     ///////////////////////////////             
        //////////////////////////////////////////////////////////////////////////////////////
        function buscaNProduto(value) {
            if (value == '') {
                sweetAlert("Atenção", "Campo do produto em branco!", "info");
            } else {
                $.ajax({
                    url: "http://localhost/git/index.php/INT_ANC/ANC/buscaNProduto",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        value: value.replace(/-/g, "")
                    },
                    beforeSend: function() {
                        swal({
                            title: "Aguarde!",
                            text: "Buscando dados...",
                            imageUrl: "http://localhost/git/img/loading.gif",
                            button: false,
                        });
                    },
                    error: function(data_error) {
                        sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                    },
                    success: function(result) {
                        console.log(result)
                        if (result == 0 || result == 0) {
                            sweetAlert("Atenção", "Produto não encontrado!", "info");
                        } else {
                            swal({
                                timer: 1,
                                title: "Aguarde!",
                                text: "Buscando dados...",
                                imageUrl: "http://localhost/git/img/loading.gif",
                                button: false,
                            });
                            $('#txtNomeProd').val(result[0].nome);
                            $('#txtUniMed').val(result[0].uni_med);
                        }
                    },
                });
            }
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: PARAMETRO SOLICITADO É A SEÇÃO, A FUNÇÃO DEVOLVE TODOS OS CÓDIGOS DE REFUGO ////                        
        //////// Autor: DANIEL                                                                /////////////
        //////// Revisado:                                                                    /////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        function slLocalRef(value, cod) {
            $.ajax({
                url: "http://localhost/git/index.php/INT_ANC/ANC/slLocalRef",
                type: "POST",
                dataType: 'json',
                data: {
                    value: value
                },
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: "http://localhost/git/img/loading.gif",
                        button: false,
                    });
                },
                error: function(data_error) {
                    sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                },
                success: function(result) {

                    $('#slCodrefugo').prop('disabled', false);
                    $('#slCodrefugo').html('');
                    $('#slCodrefugo').append('<option value=""> SELECIONE </option>');

                    $.each(result, function(index, value) {
                        $('#slCodrefugo').append('<option class="text-uppercase" value="' + value['COD_DEFEITO'] + '">' + value['COD_DEFEITO'] + ' - ' + value['DESCRICAO'] + '</option>');
                    })
                    swal({
                        timer: 1000,
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: "http://localhost/git/img/loading.gif",
                        button: false,
                    });

                    if (cod != '' || typeof(cod) != 'undefined') {
                        console.log(cod)
                        $('#slCodrefugo').val(cod);
                        // $('#slCodrefugo').selectpicker('refresh');
                    }

                },
            });
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////            PROJETO DE NÃO CONFORMIDADE               //////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: DA BAIXA NO PRODUTO REFUGADO ///////////////////////////////////////////////////                        
        //////// Autor: DANIEL                          ///////////////////////////////////////////////////
        //////// Revisado:                              ///////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        function cadastrarSaidaDefeito() {

            var tipoDocumento = 'cadastrarRefugo';

            $.ajax({
                url: "http://localhost/git/index.php/INT_ANC/ANC/cadastrarRefugo",
                type: "POST",
                dataType: 'json',
                data: $('#frmConRef').serialize(),
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: "http://localhost/git/img/loading.gif",
                        button: false,
                    });
                },
                success: function(result) {
                    $('#btnSalvaRef').attr('disabled', false);
                    if (result.cod == 1) {
                        $("#tbl_Defeitos").bootstrapTable('refresh');
                        $('#cad_defeitos').modal('hide');
                        $('#tbl_Defeitos').bootstrapTable('refresh');
                        limpar();
                        sweetAlert('OK!', '' + result.mensagens + '', 'success');
                    } else if (result.cod == 2) {
                        swal({
                            timer: 1000,
                            title: "Aguarde!",
                            text: "Cadastrando os dados...",
                            imageUrl: "http://localhost/git/img/loading.gif",
                            button: false,
                        });
                        $('#msg').html(result.mensagens);
                        $('#alert').removeClass('d-none');
                    } else if (result.cod == 3) {
                        $('#alert').addClass('d-none');
                        sweetAlert('Atenção', '' + result.mensagens + '', 'info');
                    } else if (result.cod == 6) {
                        // RETORNA SE OUVER ALGUM ERRO NA INSERÇÃO NO CASO DO DESVIO DE CONCESSÃO).
                        $('#alert').addClass('d-none');
                        $('#NumOS').prop('disabled', true);
                        $('#numQtde').prop('disabled', true);
                        sweetAlert('Atenção', '' + result.mensagens + '', 'info');
                        $('#msg').html(result.mensagens);
                        $('#alert').removeClass('d-none');
                    } else if (result.cod == 7) {
                        // RETORNA SE ESTIVER ALGUM CAMPO SEM PREENCHER(NO CASO DO DESVIO DE CONCESSÃO).
                        $('#alert').addClass('d-none');
                        $('#NumOS').prop('disabled', true);
                        $('#numQtde').prop('disabled', true);
                        swal({
                            timer: 1000,
                            title: "Aguarde!",
                            text: "Cadastrando os dados...",
                            imageUrl: "http://localhost/git/img/loading.gif",
                            showConfirmButton: false
                        });
                        $('#msg').html(result.mensagens);
                        $('#alert').removeClass('d-none');
                    } else {
                        console.log('123');
                    };
                },
                error: function(data_error) {
                    $('#btnSalvaRef').attr('disabled', false);
                    sweetAlert("Atenção...", "Aguarde...!", "info");
                },
            });
        }

        function btnDeletar(id) {
            $.ajax({
                url: "http://localhost/git/index.php/INT_ANC/ANC/btnDeletar",
                type: "POST",
                dataType: 'json',
                data: {
                    id: id
                },
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Deletando...",
                        imageUrl: "http://localhost/git/img/loading.gif",
                        button: false,
                    });
                },
                error: function(data_error) {
                    sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                },
                success: function(result) {
                    if (result.cod == 1) {
                        sweetAlert('OK', 'Deletado com sucesso', 'success');
                        $('#tbl_Defeitos').bootstrapTable('refresh');

                    } else {
                        sweetAlert('Atenção', 'Não foi possivel deletando este item', 'info');
                    }
                },
            });

        }

        function btnEdit(id) {
            $.ajax({
                url: "http://localhost/git/index.php/INT_ANC/ANC/btnEdit",
                type: "POST",
                dataType: 'json',
                data: {
                    id: id
                },
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Alterando...",
                        imageUrl: "http://localhost/git/img/loading.gif",
                        button: false,
                    });
                },
                error: function(data_error) {
                    sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                },
                success: function(result) {
                    limpar();

                    $('#cad_defeitos').modal('show');
                    $('#SalvtabPrinc').addClass('d-none');
                    $('#AlttabPrinc').removeClass('d-none');
                    $('#txtDataLan').val(result['0'].dtbaixa);
                    $('#slNumeroAlmox').val(result['0'].almox);
                    $('#sltipodoc').val(result['0'].tpdoc);
                    $('#txtNumeroDoc').val(result['0'].ndoc);
                    $('#txtProd').val(result['0'].produto);
                    $('#txtNMaquina').val(result['0'].nmaquina);
                    $('#txtChapaOp').val(result['0'].chapaop);
                    $('#txtCeCus').val(result['0'].cecus);
                    $('#numQtde').val(result['0'].qtde);
                    $('#txtobservacao').val(result['0'].observacao);
                    $('#NumOS').val(result['0'].OrdProd);
                    $('#txtOperacao').val(result['0'].operacao);
                    $('#txtDataLan').prop('readonly', true);
                    $('#slNumeroAlmox').prop('disabled', true);
                    $('#sltipodoc').prop('disabled', true);
                    $('#txtProd').prop('readonly', true);
                    $('#NumOS').prop('disabled', true);
                    $('#numQtde').prop('disabled', true);

                    buscaNProduto(result['0'].produto);

                    $('#limpartabPrinc').addClass('d-none');

                    swal({
                        timer: 100,
                        title: "Aguarde!",
                        text: "Alterando...",
                        imageUrl: "http://localhost/git/img/loading.gif",
                        button: false,
                    });

                    $.ajax({
                        url: "http://localhost/git/index.php/INT_ANC/ANC/BuscLocalCod",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            cod: result['0'].cod
                        },
                        beforeSend: function() {
                            swal({
                                title: "Aguarde!",
                                text: "Alterando...",
                                imageUrl: "http://localhost/git/img/loading.gif",
                                button: false,
                            });
                        },
                        error: function(data_error) {
                            sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                        },
                        success: function(result) {
                            $('#txtSecao').val(result['0'].local);
                            slLocalRef(result['0'].local, result['0'].cod_defeito);
                        },
                    });
                },
            });
        }

        function editarbtn(id, row) {
            return '<button class="btn btn-primary" onclick="btnEdit(\'' + id + '\')"><i class="bi bi-pencil"></i></button>\n\
                    <button class="btn btn-danger" onclick="btnDeletar(\'' + id + '\')"><i class="bi bi-trash"></i></button>'
        }

    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
</head>

<div class="circle-bcgd" style="    
    background: #6360601a;
    border-top-left-radius: 80%;
    height: 100%;
    padding-top: 50%;
    padding-bottom: 50%;
    padding-left: 50%;
    padding-right: 50%;
    position: fixed;
    z-index: -1; margin-left:25%;"></div>

<body style="overflow: visible;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="http://localhost/Crud_PHP_codeignaiter_3_bootstrap/"> Empresa</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="http://localhost/Crud_PHP_codeignaiter_3_bootstrap/"> Home <span class="sr-only">(Página atual)</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <h1 style="text-align: center; margin-top:20px;">LANÇAMENTO DE PEÇAS DANIFICADAS</h1>
        <div id="toolbar">
            <button class="btn btn-outline-danger" data-toggle="modal" onclick="modalCadDefeito()">LANÇAMENTO</button>
            <!-- <button class="btn btn-outline-success" data-toggle="modal" onclick="modalBuscaDesvio()">LANÇAMENTOS DE DESVIO DE CONCESSÃO</button> -->
        </div>
        <!-- //////////////////////////////////////////////////////////////// -->
        <!-- ///////// Objetivo: TABELA PRINCIPAL                    //////// -->
        <!-- ///////// Autor: DANIEL                                 //////// -->
        <!-- ///////// Revisado:                                     //////// -->
        <!-- //////////////////////////////////////////////////////////////// -->
        <!-- <table id="tbl_Defeitos" data-toggle="table" data-pagination="true" data-search="true" data-toolbar="#toolbar" data-url="<?php //echo base_url('/INT_ANC/ANC/retornoRegistroRefugo'); 
                                                                                                                                        ?>" -->
        <table id="tbl_Defeitos" class="table table-light" data-toggle="table" data-pagination="true" data-search="true" data-toolbar="#toolbar" data-url="<?php echo base_url('/INT_ANC/ANC/retornoRegistroRefugo'); ?>">
            <thead>
                <tr>
                    <th data-halign="center" data-align="center" data-field="dtbaixa" class="text-uppercase" data-sortable="true">DATA DA BAIXA</th>
                    <th data-halign="center" data-align="center" data-field="produto" class="text-uppercase">PRODUTO</th>
                    <th data-halign="center" data-align="center" data-field="tpdoc" class="text-uppercase">TIPO DE DOC.</th>
                    <th data-halign="center" data-align="right" data-field="ndoc" class="text-uppercase">N° DO DOC.</th>
                    <th data-halign="center" data-align="center" data-field="almox" class="text-uppercase">ALMOXARIFADO</th>
                    <th data-halign="center" data-align="left" data-field="cod" class="text-uppercase">CÓDIGO</th>
                    <th class="caixa_alta" data-halign="center" data-align="center" data-field="id" data-formatter="editarbtn">EDITAR</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- //////////////////////////////////////////////////////////////////// -->
    <!-- ///////// Objetivo: MODAL PARA CADASTRO E EDIÇÃO DE DEFEITOS /////// -->
    <!-- ///////// Autor: DANIEL                                      /////// -->
    <!-- ///////// Revisado:                                          /////// -->
    <!-- //////////////////////////////////////////////////////////////////// -->
    <div class="modal fade" id="cad_defeitos" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" Cinpal label="Close">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="htexto">LANÇAMENTO DE PEÇAS DANIFICADAS</h5>
                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmConRef">
                        <div class="row">
                            <div class="col-12 P-2">
                                <div class="alert alert-danger d-none" id="alert" role="alert">
                                    <h4 class="alert-heading">Atenção!</h4>
                                    <hr>
                                    <div id="msg" class="mb-0 pb-0 text-dark"></div>
                                    <hr>
                                    <p class="alert-heading mb-0 text-dark">Corrija os campos acima.</p>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="form-group col-3">
                                <label class="form-label">DATA:</label>
                                <input type="date" id="txtDataLan" name="txtDataLan" class="form-control" />
                            </div>
                            <div class="form-group col-9">
                                <label class="form-label">ALMOXARIFADO DE SAIDA:</label>
                                <select class="form-control" data-style="btn-dark" name="slNumeroAlmox" id="slNumeroAlmox">
                                    <option value="">SELECIONE UM ALMOXARIFADO</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="form-group col-8">
                                <label class="form-label">TIPO DE DOC:</label>
                                <select class="form-control" data-style="btn-dark" name="sltipodoc" id="sltipodoc" onchange="tipodoc(value)">
                                    <option value="RR" selected>RR - RELATÓRIO DE REFUGO</option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label class="form-label">NÚMERO DO DOCUMENTO:</label>
                                <input type="number" class="form-control" id="txtNumeroDoc" name="txtNumeroDoc" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="form-group col-3">
                                <label class="form-label">PRODUTO:</label>
                                <input type="text" class="form-control text-uppercase" id="txtProd" name="txtProd" onblur="buscaNProduto(value)">
                            </div>
                            <div class="form-group col-5">
                                <label class="form-label">NOME DO PRODUTO:</label>
                                <input type="text" class="form-control" id="txtNomeProd" name="txtNomeProd" readonly>
                            </div>
                            <div class="form-group col-2">
                                <label class="form-label">UNID. MED.:</label>
                                <input type="text" class="form-control text-uppercase" id="txtUniMed" name="txtUniMed" readonly>
                            </div>
                            <div class="form-group col-2">
                                <label class="form-label">N° OP.:</label>
                                <input type="number" class="form-control" id="NumOS" name="NumOS" min="0" step="0" value="0" oninput="validity.valid||(value='');">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="form-group col-2">
                                <label class="form-label">OPERAÇÃO:</label>
                                <input type="text" class="form-control text-uppercase" id="txtOperacao" name="txtOperacao" maxlength="5">
                            </div>

                            <div class="form-group col-4">
                                <label class="form-label">LOCAL:</label>
                                <select class="form-control text-uppercase" data-style="btn-dark" name="txtSecao" id="txtSecao" onchange="slLocalRef(value)">
                                    <option value="">SELECIONE</option>
                                    <?php
                                    foreach ($secao as $linha) {
                                    ?>
                                        <option value="<?= $linha->local; ?>"><?= $linha->local; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label">CÓDIGO DE NÃO CONFORMIDADE:</label>
                                <div>
                                    <select class="form-control text-uppercase" data-style="btn-dark text-uppercase" id="slCodrefugo" name="slCodrefugo">
                                        <option value="">SELECIONE</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="form-group col-3">
                                <label class="form-label">N° MAQUINA:</label>
                                <input type="number" class="form-control text-uppercase" id="txtNMaquina" name="txtNMaquina" min="0" step="0" oninput="validity.valid||(value='');">
                            </div>
                            <div class="form-group col-3">
                                <label class="form-label">CHAPA DO RESPONSÁVEL:</label>
                                <input type="number" class="form-control" id="txtChapaOp" name="txtChapaOp" min="0" step="0" oninput="validity.valid||(value='');">
                            </div>
                            <div class="form-group col-4">
                                <label class="form-label">CENTRO CUSTO:</label>
                                <select id="txtCeCus" name="txtCeCus" data-width="100%" class="form-control text-uppercase" data-style="btn-dark">
                                    <option value="">SELECIONE</option>
                                    <?php
                                    foreach ($depto as $linha) {
                                    ?>
                                        <option value="<?= $linha->CODCC; ?>"><?= $linha->CODCC ?> - <?= $linha->DESCRICAO ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-2">
                                <label class="form-label">QTDE:</label>
                                <input type="number" class="form-control text-uppercase" id="numQtde" name="numQtde" min="0" step="0" oninput="validity.valid||(value='');">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <label class="form-label">OBSERVAÇÃO:</label>
                                <textarea type="text" class="form-control text-uppercase" id="txtobservacao" name="txtobservacao" maxlength="255" onkeypress="blockEvent(event, this)"></textarea>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer bg-dark text-white py-1" id="btnCadastrar">
                    <div class="" id="limpartabPrinc">
                        <button type="button" class="btn btn-light btn-block" onclick="limpar()"><i class="fas fa-eraser"></i> LIMPAR</button>
                    </div>
                    <div class="" id="SalvtabPrinc">
                        <button type="button" id="btnSalvaRef" class="btn btn-success btn-block" onclick="cadastrarSaidaDefeito()"><i class="fas fa-save"></i> SALVAR</button>
                    </div>
                    <div class="" id="AlttabPrinc">
                        <button type="button" id="btnEditRef" class="btn btn-warning btn-block" onclick="alterarSaidaDefeito()"><i class="fas fa-save"></i> ALTERAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>
</body>

</html>
