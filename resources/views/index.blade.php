<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Styles -->

    </head>
    <body>
        <div class="container" style="margin-top: 3%">

            <h3>Inserindo Reunião Via Zoom</h3>
            <form>
                <div class="form-row">
                    <div class="col-6">
                        <label>Assunto da reunião:</label>
                        <input type="text" id="assunto" class="form-control" placeholder="Informe o assunto da sua reunião">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-2">
                        <label>Data:</label>
                        <input type="date" id="data" class="form-control" value="<?php echo date('Y-m-d') ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-2">
                        <label>Hora:</label>
                        <input type="time" id="hora" class="form-control">
                    </div>
                </div>
                <br/>
                <button class="btn btn-secondary" id="agendar"> AGENDAR</button>
            </form>
        </div>

    <!-- MODAL-->
        <div class="modal fade" id="sucesso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reunião Agendada</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="assuntoreuniao"></p>
                        <p id="datareuniao"></p>
                        <p id="horareuniao"></p>
                        <p id="duracaoreuniao"></p>
                        <p id="linkreuniao"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('#agendar').on('click',function (e){
                e.preventDefault();
                let dados = {
                    assunto: $('#assunto').val(),
                    data: $('#data').val(),
                    hora: $('#hora').val()
                };
                $.ajax({
                    url: '{{ route('api.create') }}',
                    type: 'post',
                    dataType: 'json',
                    data: dados,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                })
                .done(function(val){
                    console.log(val);
                    $('#assuntoreuniao').html('<b>Assunto: </b>'+val[0]['assunto']);
                    $('#datareuniao').html('<b>Data: </b>'+val[0]['data']);
                    $('#horareuniao').html('<b>Hora: </b>'+val[0]['hora']);
                    $('#duracaoreuniao').html('<b>Duração: </b>'+val[0]['duracao']);
                    $('#linkreuniao').html('<b>Link: </b>'+val[0]['link']);
                    $('#sucesso').modal('show');
                })
                .fail(function (x,status,val){
                    console.log(x)
                });

            });
        });
    </script>
</html>
