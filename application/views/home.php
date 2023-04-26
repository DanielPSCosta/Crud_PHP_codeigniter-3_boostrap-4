<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Cinpal</title>

    <script src="https://kit.fontawesome.com/775fd40529.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="//code.jquery.com/jquery-3.6.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- this should go after your </body> -->
    <link rel="stylesheet" type="text/css" href="/jquery.datetimepicker.css" />
    <script src="/jquery.js"></script>
    <script src="/build/jquery.datetimepicker.full.min.js"></script>

    <script>
        function tipoDC(value) {
            return 'DC - DESVIO DE CONCESSÃO';
        }

        function blockEvent(e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        }

        function BuscaDesConcess(index, row) {
            var html = [];
            $.each(row, function(key, value) {

                // SE A CHAVE(key) FOR IGUAL A 'nomepc' ENTÃO A CHAVE TERÁ O NOME "NOME MAQUINA".
                //QUANDO SE ABRE O MAIS('+') QUE ESTÁ NA TABELA PRINCIPAL, ESSA FUNÇÃO ALTERA O NOME QUE ESTA NO '+', DE 'nomepc' PARA 'nome maquina'.
                let include = true;

                if (key == 'motivo') {
                    value = value.toUpperCase();
                }

                if (key == 'produto' || key == 'dtmov' || key == 'seq' || key == 'tpdoc' || key == 'nrodoc' || key == 'dtcria' || key == 'estatus' || key == 'qtde' || key == 'numos') {
                    include = false;
                }

                if (include) {
                    html.push('<p style="padding-top:1%"><b style="text-transform: uppercase" >' + key + ':</b> ' + value + '</p>');
                }
            })
            return html.join('')
        }

        function dtDesvConc(value) {
            return moment(value).format('L');
        }

        function modalBuscaDesvio() {
            $('#Busc_DesConc').modal('show');

            $.ajax({
                url: base_url + "INT_ANC/ANC/BuscDesvioConc",
                type: "POST",
                dataType: 'json',
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: base_url + "../img/loading.gif",
                        showConfirmButton: false
                    });
                },
                error: function(data_error) {
                    sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                },
                success: function(result) {
                    swal({
                        timer: 100,
                        title: "Aguarde!",
                        text: "Cadastrando os dados...",
                        imageUrl: base_url + "../img/loading.gif",
                        showConfirmButton: false
                    });
                    $("#DesvioConces").bootstrapTable('removeAll');
                    $("#DesvioConces").bootstrapTable('append', result);
                },
            });

        }

        function alterarSaidaDefeito() {
            $('#txtDataLan').prop('readonly', false);
            $('#slNumeroAlmox').prop('disabled', false);
            $('#sltipodoc').prop('disabled', false);
            $('#txtProd').prop('readonly', false);
            $('#NumOS').prop('disabled', false);
            $('#numQtde').prop('disabled', false);
            $('#slNumeroAlmox').selectpicker('refresh');
            $('#sltipodoc').selectpicker('refresh');

            $.ajax({
                url: base_url + "INT_ANC/ANC/alterarSaidaDefeito",
                type: "POST",
                dataType: 'json',
                data: $('#frmConRef').serialize(),
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: base_url + "../img/loading.gif",
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
                        $('#slNumeroAlmox').selectpicker('refresh');
                        $('#sltipodoc').selectpicker('refresh');
                        sweetAlert('OK!', '' + result.mensagens + '', 'success');
                        $('#cad_defeitos').modal('hide');

                    } else if (result['cod'] == 4) {
                        $('#txtDataLan').prop('readonly', true);
                        $('#slNumeroAlmox').prop('disabled', true);
                        $('#sltipodoc').prop('disabled', true);
                        $('#txtProd').prop('readonly', true);
                        $('#NumOS').prop('disabled', true);
                        $('#numQtde').prop('disabled', true);
                        $('#slNumeroAlmox').selectpicker('refresh');
                        $('#sltipodoc').selectpicker('refresh');

                        swal({
                            timer: 1000,
                            title: "Aguarde!",
                            text: "Cadastrando os dados...",
                            imageUrl: base_url + "../img/loading.gif",
                            showConfirmButton: false
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

                        $('#slNumeroAlmox').selectpicker('refresh');
                        $('#sltipodoc').selectpicker('refresh');
                        sweetAlert('Oops...!', '' + result.mensagens + '', 'info');
                    }
                },
            });
        }

        function obsfun(nrodoc, row) {
            return '<button type="button" class="btn btn-outline-success" onclick="psqNConforme(\'' + nrodoc + '\',\'' + row.produto + '\',\'' + row.tpdoc + '\')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
        }

        function psqNConforme(nrodoc, produto, tpdoc) {
            if (tpdoc == 'RR') {
                $('#txtSecao').prop('disabled', false);
                $('#txtSecao').selectpicker('refresh');
            } else {
                $('#txtSecao').prop('disabled', false);
                $('#txtSecao').selectpicker('refresh');

                $('#slCodrefugo').prop('disabled', false);
                $('#slCodrefugo').selectpicker('refresh');
            }
            $('#limpartabPrinc').addClass('d-none');
            $('#SalvtabPrinc').addClass('d-none');

            $('#AlttabPrinc').removeClass('d-none');
            $('#limpartabEdit').removeClass('d-none');

            limpar();
            $.ajax({
                url: base_url + "INT_ANC/ANC/psqNConforme",
                type: "POST",
                dataType: 'json',
                data: {
                    nrodoc: nrodoc,
                    produto: produto,
                    tpdoc: tpdoc
                },
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: base_url + "../img/loading.gif",
                        showConfirmButton: false
                    });
                },
                error: function(data_error) {
                    sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                },
                success: function(result) {
                    console.log(result);
                    //// ------------------------------------------------------------------------
                    //// INSERI OS VALORES NOS CAMPOS  QUANDO O USUARIO CLICAR NA LUPA DE EDIÇÃO. 
                    $('#txtProd').val(result[0]['produto']);
                    buscaNProduto(result[0]['produto']);
                    var data = moment(result[0]['dtcria']).format('L');
                    $('#txtDataLan').val(data);
                    $('#txtNumeroDoc').val(result[0]['nrodoc']);
                    $('#NumOS').val(result[0]['nroosu']);
                    $('#txtOperacao').val(result[0]['codoperacao']);
                    $('#txtNMaquina').val(result[0]['codmaqui']);
                    $('#txtChapaOp').val(result[0]['operador']);
                    $('#txtobservacao').val(result[0]['motivo']);
                    $('#numQtde').val(parseFloat(result[0]['qtde']).toFixed(0));

                    // -------------------------------------------------------------
                    //  RETIRA O BOTÃO SALVAR E COLOCAR O ALTERAR NO LUGAR 
                    // $('#AlttabPrinc').removeClass('d-none');
                    // $('#limpartabPrinc').removeClass('d-none');
                    // $('#SalvtabPrinc').addClass('d-none');
                    // -------------------------------------------------------------

                    var tipoNumDocumento = result[0]['almorig'];

                    $('#slNumeroAlmox').val(tipoNumDocumento);
                    var tipoDocumento = result[0]['tpdoc'];
                    $('#slNumeroAlmox').selectpicker('refresh');

                    $('#sltipodoc').val(tipoDocumento);
                    $('#sltipodoc').selectpicker('refresh');

                    $('#txtCeCus').selectpicker('val', result[0]['codcc']);
                    $('#txtCeCus').selectpicker('refresh');

                    $('#slNumeroAlmox').selectpicker('refresh');
                    $('#sltipodoc').selectpicker('refresh');
                    $('#txtCeCus').selectpicker('refresh');
                    // -------------------------------------------------------------
                    if (result[0]['coddefeito'] == 0) {
                        $('#txtCeCus').prop('disabled', true);
                        $('#txtCeCus').selectpicker('refresh');
                        $('#txtChapaOp').prop('disabled', false);

                        $('#numQtde').prop('disabled', false);
                        $('#txtNMaquina').prop('disabled', false);
                        $('#txtOperacao').prop('disabled', false);
                        $('#cad_defeitos').modal('show');
                    } else {
                        $.ajax({
                            url: base_url + "INT_ANC/ANC/BuscLocalCod",
                            type: "POST",
                            dataType: 'json',
                            data: {
                                value: result[0]['coddefeito']
                            },
                            beforeSend: function() {
                                swal({
                                    title: "Aguarde!",
                                    text: "Buscando dados...",
                                    imageUrl: base_url + "../img/loading.gif",
                                    showConfirmButton: false
                                });
                            },
                            error: function(data_error) {
                                sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                            },
                            success: function(data) {

                                $('#txtSecao').val(data[0]['local']);
                                $('#txtSecao').selectpicker('refresh');

                                slLocalRef(data[0]['local'], data[0]['id_defeitos']);


                                $('#numQtde').prop('disabled', true);

                                swal({
                                    title: "Aguarde!",
                                    text: "Buscando dados...",
                                    imageUrl: base_url + "../img/loading.gif",
                                    showConfirmButton: false
                                });
                                $('#cad_defeitos').modal('show');
                            },
                        });

                    }

                    $('#txtDataLan').prop('readonly', true);
                    $('#slNumeroAlmox').prop('disabled', true);
                    $('#sltipodoc').prop('disabled', true);
                    $('#txtProd').prop('readonly', true);
                    $('#NumOS').prop('disabled', true);
                    $('#numQtde').prop('disabled', true);
                    $('#txtCeCus').prop('disabled', false);
                    $('#txtCeCus').selectpicker('refresh');
                    $('#slNumeroAlmox').selectpicker('refresh');
                    $('#sltipodoc').selectpicker('refresh');
                },
            });
        }

        function nomeTipoDoc(value) {
            if (value == 'RR') {
                return 'RELATÓRIO DE REFUGO';
            } else {
                return 'RETRABALHO';
            }
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
        ////////////////////// DATAPICKER DO "DATA LANÇAMENTO" ///////////////////////
        //////////////////////////////////////////////////////////////////////////////
        jQuery('#txtDataLan').datetimepicker({
            format: 'unixtime',
            maxDate: new Date()
        });

        //////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: ABRE A MODAL PARA CADASTRAR UM DEFEITO ////////////////////             
        //////// Criação: 21/02/2022                              //////////////////// 
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

            // $('#slNumeroAlmox').selectpicker('refresh');
            // $('#sltipodoc').selectpicker('refresh');

            $('#limpartabPrinc').removeClass('d-none');
            $('#SalvtabPrinc').removeClass('d-none');

            $('#AlttabPrinc').addClass('d-none');
            $('#limpartabEdit').addClass('d-none');
            // limpar();
            $('#cad_defeitos').modal('show');
        }

        //////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: CARREGA ITENS ASSIM QUE A TELA É INICIADA  ////////////////             
        //////// Criação: 04/02/2022                              //////////////////// 
        //////// Autor: DANIEL                                    ////////////////////        
        //////// Revisado:                                        ////////////////////        
        //////////////////////////////////////////////////////////////////////////////
        $(document).ready(function() {
            CarregaItens()
        });

        //////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: CARREGA ITENS NA MODAL                 ////////////////////             
        //////// Criação: 04/02/2022                              //////////////////// 
        //////// Autor: DANIEL                                    ////////////////////        
        //////// Revisado:                                        ////////////////////        
        //////////////////////////////////////////////////////////////////////////////
        function CarregaItens() {
            $.ajax({
                url: base_url + "INT_ANC/ANC/BuscaAlmoxOrig",
                type: "POST",
                dataType: 'json',
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: base_url + "../img/loading.gif",
                        showConfirmButton: false
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
                        imageUrl: base_url + "../img/loading.gif",
                        showConfirmButton: false
                    });

                    $('#txtSecao').attr('disabled', false);
                    $('#AlttabPrinc').addClass('d-none');
                    $('#limpartabPrinc').removeClass('d-none');
                    $('#SalvtabPrinc').removeClass('d-none');

                    $('#slCodrefugo').prop('disabled', true);
                    $('#slCodrefugo').selectpicker('refresh');

                    $('#slNumeroAlmox').selectpicker('refresh');
                    $('#slNumeroAlmox').html('');
                    $('#slNumeroAlmox').append('<option value=""> SELECIONE </option>');

                    $.each(result, function(index, value) {
                        $('#slNumeroAlmox').append('<option class="text-uppercase" value="' + value['almorig'] + '">' + value['almorig'] + ' - ' + value['descricao'] + '</option>').selectpicker('refresh');
                    });
                },
            });
        }

        //////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: LIMPA A MODAL NO ESTADO DE CADASTRO   /////////////////////                       
        //////// Criação: 21/02/2022                             /////////////////////      
        //////// Autor: DANIEL                                   /////////////////////      
        //////// Revisado:                                       /////////////////////      
        //////////////////////////////////////////////////////////////////////////////
        function limpar() {
            $('#frmConRef')[0].reset();
            $('#alert').addClass('d-none')
            $('#txtSecao').selectpicker('refresh');
            $('#slNumeroAlmox').selectpicker('refresh');
            $('#slCodrefugo').prop('disabled', true);
            $('#slCodrefugo').selectpicker('refresh');
            $('#slCodrefugo').html('');
            $('#slCodrefugo').append('<option value=""> SELECIONE </option>');
            $('#slNumeroAlmox').selectpicker('refresh');
            $('#sltipodoc').selectpicker('refresh');
            $('#txtmotivorefugo').val('');
            $("#txtCeCus").selectpicker('refresh');

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

        }

        //////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: BUSCA O TIPO DO DOCUMENTO. EX: RR,RB   ////////////////////                           
        //////// Criação: 24/02/2022                              ////////////////////      
        //////// Autor: DANIEL                                    ////////////////////       
        //////// Revisado:                                        ////////////////////       
        //////////////////////////////////////////////////////////////////////////////
        function BuscTpDoc(value) {
            $.ajax({
                url: base_url + "INT_ANC/ANC/BuscTpDoc",
                type: "POST",
                dataType: 'json',
                data: {
                    value: value
                },
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: base_url + "../img/loading.gif",
                        showConfirmButton: false
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
                        imageUrl: base_url + "../img/loading.gif",
                        showConfirmButton: false
                    });
                    $('#txtNomeDoc').val(result[0].descricao);
                },
            });
        }

        //////////////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: BUSCA O NOME DO PRODUTO             ///////////////////////////////                 
        //////// Criação: 24/02/2022                           ///////////////////////////////             
        //////// Autor: DANIEL                                 ///////////////////////////////             
        //////// Revisado:                                     ///////////////////////////////             
        //////////////////////////////////////////////////////////////////////////////////////
        function buscaNProduto(value) {
            if (value == '') {
                sweetAlert("Atenção", "Campo do produto em branco!", "info");
            } else {
                $.ajax({
                    url: base_url + "INT_ANC/ANC/buscaNProduto",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        value: value.replace(/-/g, "")
                    },
                    beforeSend: function() {
                        swal({
                            title: "Aguarde!",
                            text: "Buscando dados...",
                            imageUrl: base_url + "../img/loading.gif",
                            showConfirmButton: false
                        });
                    },
                    error: function(data_error) {
                        sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                    },
                    success: function(result) {
                        if (result == 0) {
                            sweetAlert("Atenção", "Produto não encontrado!", "info");
                        } else {
                            swal({
                                timer: 1,
                                title: "Aguarde!",
                                text: "Buscando dados...",
                                imageUrl: base_url + "../img/loading.gif",
                                showConfirmButton: false
                            });
                            $('#txtUniMed').val(result[0].prod_codunime);
                            $('#txtNomeProd').val(result[0].prod_descricao);
                        }
                    },
                });
            }
        }

        //////////////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: BUSCA CHAPA                         ///////////////////////////////                 
        //////// Criação: 24/02/2022                           ///////////////////////////////             
        //////// Autor: DANIEL                                 ///////////////////////////////             
        //////// Revisado:                                     ///////////////////////////////             
        //////////////////////////////////////////////////////////////////////////////////////
        function buscaNChapa(value) {
            if (value == '') {
                sweetAlert("Atenção", "Campo da chapa do operador em branco!", "info");
            } else {
                $.ajax({
                    url: base_url + "INT_ANC/ANC/buscaNChapa",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        value: value.replace(/-/g, "")
                    },
                    beforeSend: function() {
                        swal({
                            title: "Aguarde!",
                            text: "Buscando dados...",
                            imageUrl: base_url + "../img/loading.gif",
                            showConfirmButton: false
                        });
                    },
                    error: function(data_error) {
                        sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                    },
                    success: function(result) {
                        if (result == 0) {
                            sweetAlert("Atenção", "Chapa não encontrada!", "info");
                            $('#txtChapaOp').val('');
                        } else {
                            swal({
                                timer: 1,
                                title: "Aguarde!",
                                text: "Buscando dados...",
                                imageUrl: base_url + "../img/loading.gif",
                                showConfirmButton: false
                            });
                        }
                    },
                });
            }
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //////// Objetivo: PARAMETRO SOLICITADO É A SEÇÃO, A FUNÇÃO DEVOLVE TODOS OS CÓDIGOS DE REFUGO ////                        
        //////// Criação: 24/02/2022                                                          /////////////
        //////// Autor: DANIEL                                                                /////////////
        //////// Revisado:                                                                    /////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        function slLocalRef(value, cod) {
            $.ajax({
                url: base_url + "INT_ANC/ANC/slLocalRef",
                type: "POST",
                dataType: 'json',
                data: {
                    value: value
                },
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: base_url + "../img/loading.gif",
                        showConfirmButton: false
                    });
                },
                error: function(data_error) {
                    sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                },
                success: function(result) {


                    $('#slCodrefugo').prop('disabled', false);
                    $('#slCodrefugo').selectpicker('refresh');
                    $('#slCodrefugo').html('');
                    $('#slCodrefugo').append('<option value=""> SELECIONE </option>');

                    $.each(result, function(index, value) {
                        $('#slCodrefugo').append('<option class="text-uppercase" value="' + value.id_defeitos + '">' + value.cod_defeito + ' - ' + value.descricao + '</option>').selectpicker('refresh');
                    })
                    swal({
                        timer: 1000,
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: base_url + "../img/loading.gif",
                        showConfirmButton: false
                    });

                    if (cod != '' || typeof(cod) != 'undefined') {
                        $('#slCodrefugo').val(cod);
                        $('#slCodrefugo').selectpicker('refresh');
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
        //////// Objetivo: DA BAIXA NO PRODUTO REFUGADO    ///////////////////////////////////////////////////                        
        //////// Criação: 24/02/2022                    ///////////////////////////////////////////////////
        //////// Autor: DANIEL                          ///////////////////////////////////////////////////
        //////// Revisado:                              ///////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        function cadastrarSaidaDefeito() {
            $('#txtDataLan').prop('readonly', false);
            $('#slNumeroAlmox').prop('disabled', false);
            $('#sltipodoc').prop('disabled', false);
            // $('#txtNumeroDoc').prop('readonly', false);
            $('#txtProd').prop('readonly', false);
            $('#NumOS').prop('disabled', false);
            $('#numQtde').prop('disabled', false);

            $('#slNumeroAlmox').selectpicker('refresh');
            $('#sltipodoc').selectpicker('refresh');

            if ($('#sltipodoc').val() == 'RET') {
                var tipoDocumento = 'cadastraRetrabalho';
            } else if ($('#sltipodoc').val() == 'RR') {
                var tipoDocumento = 'cadastrarRefugo';
            } else {
                var tipoDocumento = 'cadastrarDesvioConc';
            }

            $('#btnSalvaRef').attr('disabled', true);
            $.ajax({
                url: base_url + "INT_ANC/ANC/" + tipoDocumento,
                type: "POST",
                dataType: 'json',
                data: $('#frmConRef').serialize(),
                beforeSend: function() {
                    swal({
                        title: "Aguarde!",
                        text: "Buscando dados...",
                        imageUrl: base_url + "../img/loading.gif",
                        showConfirmButton: false
                    });
                },
                error: function(data_error) {
                    $('#btnSalvaRef').attr('disabled', false);
                    sweetAlert("Atenção...", "Aguarde...!", "info");
                },
                success: function(result) {
                    $('#btnSalvaRef').attr('disabled', false);
                    if (result.cod == 1) {
                        $("#tbl_Defeitos").bootstrapTable('refresh');
                        $('#cad_defeitos').modal('hide');
                        $('#tbl_Defeitos').bootstrapTable('refresh');
                        limpar();
                        sweetAlert('OK!', '' + result.mensagens + '', 'success');

                        $("#txtCeCus").selectpicker('refresh');

                    } else if (result.cod == 2) {
                        swal({
                            timer: 1000,
                            title: "Aguarde!",
                            text: "Cadastrando os dados...",
                            imageUrl: base_url + "../img/loading.gif",
                            showConfirmButton: false
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
                            imageUrl: base_url + "../img/loading.gif",
                            showConfirmButton: false
                        });
                        $('#msg').html(result.mensagens);
                        $('#alert').removeClass('d-none');
                    };
                },
            });
        }
        //////////////////////////////////////////////////////////////////////////////////////////////
        ///////// VALIDA NÚMERO DO DOCUMENTO                             /////////////////////////////
        ///////// CRIADO POR DANIEL                                      /////////////////////////////
        ///////// 05/09/2022                                             /////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        function validaNroDoc(value) {
            if (value === 0) {
                sweetAlert('Atenção', 'NÚMERO DO DOCUMENTO ZERADO OU EM BRANCO', 'info');
            } else if (value == '' || value == null) {

            } else {

                $.ajax({
                    url: base_url + "INT_ANC/ANC/validaNroDoc",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        value: value
                    },
                    beforeSend: function() {
                        swal({
                            title: "Aguarde!",
                            text: "Validando...",
                            imageUrl: base_url + "../img/loading.gif",
                            showConfirmButton: false
                        });
                    },
                    error: function(data_error) {
                        sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
                    },
                    success: function(result) {
                        if (result > 0) {
                            sweetAlert('Atenção', 'NÚMERO DO DOCUMENTO JÁ CADASTRADO', 'info');
                        } else {
                            swal({
                                timer: 1000,
                                title: "Aguarde!",
                                text: "Validando...",
                                imageUrl: base_url + "../img/loading.gif",
                                showConfirmButton: false
                            });
                        }
                    },
                });
            }

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

    <div class="container-fluid">
        <h1 style="text-align: center; margin-top:70px;">REGISTRO DE NÃO CONFORMIDADE</h1>
        <div id="toolbar">
            <button class="btn btn-outline-danger" data-toggle="modal" onclick="modalCadDefeito()">SAÍDA DE NÃO CONFORMIDADE</button>
            <button class="btn btn-outline-success" data-toggle="modal" onclick="modalBuscaDesvio()">LANÇAMENTOS DE DESVIO DE CONCESSÃO</button>
        </div>
        <!-- //////////////////////////////////////////////////////////////// -->
        <!-- ///////// Objetivo: TABELA PRINCIPAL                    //////// -->
        <!-- ///////// Criação: 21/02/2022                           //////// -->
        <!-- ///////// Autor: DANIEL                                 //////// -->
        <!-- ///////// Revisado:                                     //////// -->
        <!-- //////////////////////////////////////////////////////////////// -->
        <!-- <table id="tbl_Defeitos" data-toggle="table" data-pagination="true" data-search="true" data-toolbar="#toolbar" data-url="<?php //echo base_url('/INT_ANC/ANC/retornoRegistroRefugo'); 
                                                                                                                                        ?>"> -->
        <table id="tbl_Defeitos" data-toggle="table" data-pagination="true" data-search="true" data-toolbar="#toolbar">
            <thead>
                <tr>
                    <th data-halign="center" data-align="center" data-field="dtmov" class="text-uppercase" data-sortable="true">DATA DA BAIXA</th>
                    <th data-halign="center" data-align="center" data-field="horacria" class="text-uppercase" data-formatter="horacr">HORA</th>
                    <th data-halign="center" data-align="center" data-field="produto" class="text-uppercase">PRODUTO</th>
                    <th data-halign="center" data-align="center" data-field="tpdoc" class="text-uppercase" data-formatter="nomeTipoDoc">TIPO DE DOC.</th>
                    <th data-halign="center" data-align="right" data-field="nrodoc" class="text-uppercase">N° DO DOC.</th>
                    <th data-halign="center" data-align="center" data-field="almoxarifado" class="text-uppercase">ALMOXARIFADO</th>
                    <th data-halign="center" data-align="left" data-field="defeito" class="text-uppercase">CÓDIGO</th>
                    <th data-halign="center" data-align="left" data-field="descricao" class="text-uppercase">DEFEITO</th>
                    <th data-halign="center" data-align="right" data-field="qtde" class="text-uppercase" data-formatter="editQtde" data-sortable="true">QTDE.</th>
                    <th data-halign="center" data-align="center" class="text-uppercase" data-field="nrodoc" data-formatter="obsfun">EDITAR</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- //////////////////////////////////////////////////////////////////// -->
    <!-- ///////// Objetivo: MODAL PARA CADASTRO E EDIÇÃO DE DEFEITOS /////// -->
    <!-- ///////// Criação: 21/02/2022                                /////// -->
    <!-- ///////// Autor: DANIEL                                      /////// -->
    <!-- ///////// Revisado:                                          /////// -->
    <!-- //////////////////////////////////////////////////////////////////// -->
    <div class="modal fade" id="cad_defeitos" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" Cinpal label="Close">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="htexto">CONTROLE DE SAÍDA DE NÃO CONFORMIDADE</h5>
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
                                <input type="text" class="form-control" id="txtDataLan" name="txtDataLan" placeholder="Ex: DD/MM/AAAA" data-date-format="DD/MM/YYYY" />
                            </div>
                            <div class="form-group col-9">
                                <label class="form-label">ALMOXARIFADO DE SAIDA:</label>
                                <select class="form-control selectpicker" data-style="btn-dark" name="slNumeroAlmox" id="slNumeroAlmox">
                                    <option value="">SELECIONE UM ALMOXARIFADO</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="form-group col-8">
                                <label class="form-label">TIPO DE DOC:</label>
                                <select class="form-control selectpicker" data-style="btn-dark" name="sltipodoc" id="sltipodoc" onchange="tipodoc(value)">
                                    <option value="">SELECIONE</option>
                                    <option value="RR">RR - RELATÓRIO DE REFUGO</option>
                                    <option value="RET">RET - RETRABALHO</option>
                                    <option value="DC">DC - DESVIO DE CONCESSÃO</option>
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
                                <select class="form-control text-uppercase selectpicker" data-style="btn-dark" name="txtSecao" id="txtSecao" onchange="slLocalRef(value)">
                                    <option value="">SELECIONE</option>
                                    <?php
                                    foreach ($secao as $linha) {
                                    ?>
                                        <option value="<?= $linha['local']; ?>"><?= $linha['local']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label">CÓDIGO DE NÃO CONFORMIDADE:</label>
                                <div>
                                    <select class="form-control text-uppercase selectpicker" data-style="btn-dark text-uppercase" id="slCodrefugo" name="slCodrefugo">
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
                                <input type="number" class="form-control" id="txtChapaOp" name="txtChapaOp" onblur="buscaNChapa(value);" min="0" step="0" oninput="validity.valid||(value='');">
                            </div>
                            <div class="form-group col-4">
                                <label class="form-label">CENTRO CUSTO:</label>
                                <!-- <input type="number" class="form-control" id="txtCeCus" name="txtCeCus"  min="0" step="0.01" oninput="validity.valid||(value='');"> -->
                                <select id="txtCeCus" name="txtCeCus" data-width="100%" class="form-control text-uppercase selectpicker" data-style="btn-dark">
                                    <option value="">SELECIONE</option>
                                    <?php
                                    foreach ($depto as $linha) {
                                    ?>
                                        <option value="<?= $linha['depto']; ?>"><?= $linha['depto'] ?> - <?= $linha['cecus_descricao'] ?></option>
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
                <div class="modal-footer bg-dark text-white pb-1" id="btnCadastrar">
                    <div class="" id="limpartabPrinc">
                        <button type="button" class="btn btn-light btn-block" onclick="limpar()"><i class="fas fa-eraser"></i> LIMPAR</button>
                    </div>
                    <div class="" id="limpartabEdit">
                        <button type="button" class="btn btn-light btn-block" onclick="limparEdit()"><i class="fas fa-eraser"></i> LIMPAR</button>
                    </div>
                    <div class="" id="SalvtabPrinc">
                        <button type="button" id="btnSalvaRef" class="btn btn-success btn-block" onclick="cadastrarSaidaDefeito()"><i class="fas fa-save"></i> SALVAR</button>
                    </div>
                    <div class="" id="AlttabPrinc">
                        <button type="button" id="btnEditRef" class="btn btn-orange btn-block" onclick="alterarSaidaDefeito()"><i class="fas fa-save"></i> ALTERAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="Busc_DesConc" tabindex="-1" role="dialog" aria-label class="form-label" ledby="myLargeModallabel class=" form-label" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="htexto">LANÇAMENTOS DE DESVIO DE CONCESSÃO</h5>
                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="DesvioConces" data-toggle="table" data-detail-view="true" data-detail-formatter="BuscaDesConcess" class="table" data-show-columns-toggle-all="true" data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th class="caixa_alta m-2" data-halign="center" data-align="center" data-field="produto">PRODUTO</th>
                                <th class="caixa_alta text-uppercase" data-align="center" data-halign="center" data-field="dtmov" data-formatter="dtDesvConc">DATA</th>
                                <th class="caixa_alta" data-align="CENTER" data-halign="center" data-field="tpdoc" data-formatter="tipoDC">TIPO DE DOCUMENTO</th>
                                <th class="caixa_alta" data-align="CENTER" data-halign="center" data-field="seq">NUM. DOC.</th>
                                <th class="caixa_alta" data-halign="center" data-align="center" data-field="qtde">QUANTIDADE</th>
                                <th class="caixa_alta" data-halign="center" data-align="center" data-field="numos">OP</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>
</body>

</html>