{{ Form::hidden('user_id', auth()->user()->id) }}
<div class="form-row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="data">Data do Show</label>
            <input type="date" id="ultimoDiaTrab" name="data" class="form-control" onkeypress="return false" />
            <span id="msg_data"></span>

        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="hora">Hora do Show</label>
            <input type="hora" class="form-control" id="hora" placeholder="Hora:Minuto" name="hora">
            <span id="msg_hora"></span>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="cep">CEP</label>
            <input type="cep" class="form-control" id="cep" name="cep" placeholder="Informe o CEP"
                onblur='pesquisacep(this.value);'>
            <span id="msg_cep"></span>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="rua">Rua</label>
            <input type="rua" class="form-control" id="rua" name="rua" placeholder="Informe a Rua">
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-5">
        <div class="form-group">
            <label for="bairro">Bairro</label>
            <input type="bairro" class="form-control" id="bairro" name="bairro" placeholder="Informe o Bairro">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="cidade">Cidade</label>
            <input type="cidade" class="form-control" id="cidade" name="cidade" placeholder="Informe a Cidade"
                readonly="">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="estado" class="form-control" id="uf" maxlength="2" name="estado" placeholder="Informe o Estado"
                readonly="">
        </div>
    </div>
</div>
<input type="hidden" name="ibge" id="ibge">

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

    <script>
        function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('cep').value = ("");
            document.getElementById('rua').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
            document.getElementById('uf').value = ("");
            document.getElementById('ibge').value = ("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('rua').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
                document.getElementById('uf').value = (conteudo.uf);
                document.getElementById('ibge').value = (conteudo.ibge);
            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'CEP não encontrado.'
                });
            }
        }

        function pesquisacep(valor) {

            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('rua').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";
                    document.getElementById('uf').value = "...";
                    document.getElementById('ibge').value = "...";

                    //Cria um elemento javascript.
                    var script = document.createElement('script');

                    //Sincroniza com o callback.
                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);

                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        };

    </script>

    <script>
        var numeros = "123456789";
        var msg_hora = document.getElementById('msg_hora');
        var msg_cep = document.getElementById('msg_cep');
        if (msg_hora !== null) {
            if (document.getElementById("hora")) {
                document.getElementById("hora").onkeypress = function(e) {
                    var chr = String.fromCharCode(e.which);
                    if (numeros.indexOf(chr) < 0) {
                        msg_hora.innerHTML = "Somente número no campo de Hora.";
                        msg_hora.style.color = "red";
                        msg_hora.style.display = "block";
                        return false;
                    } else {
                        msg_hora.style.display = 'none';
                    }
                };
            }
        }
        if (msg_cep !== null) {
            if (document.getElementById("cep")) {
                document.getElementById("cep").onkeypress = function(e) {
                    var chr = String.fromCharCode(e.which);
                    if (numeros.indexOf(chr) < 0) {
                        msg_cep.innerHTML = "Somente número no campo de CEP.";
                        msg_cep.style.color = "red";
                        msg_cep.style.display = "block";
                        return false;
                    } else {
                        msg_cep.style.display = 'none';
                    }
                };
            }
        }

        var today = new Date().toISOString().split('T')[0];
        document.getElementsByName("data")[0].setAttribute('min', today);

        $('input[type="date"]').on('keydown', function(e) {

            var msg_data = document.getElementById('msg_data');
            if (msg_data !== null) {
                msg_data.innerHTML = "Somente escolha a data";
                msg_data.style.color = "red";
                msg_data.style.display = "block";
                return false;
            }
            e.preventDefault();
        });
        $('input[type="date"]').on('click', function(e) {
            var msg_data = document.getElementById('msg_data');
            msg_data.style.display = 'none';
        });

        var input = document.getElementById('ultimoDiaTrab');
        input.addEventListener('change', function() {
            var agora = new Date();
            var escolhida = new Date(this.value);
            if (escolhida < agora) this.value = [agora.getFullYear(), agora.getMonth() + 1, agora.getDate() + 1]
                .map(v => v < 10 ? '0' + v : v).join('-');
        });

    </script>

    <script>
        var mask = function(val) {
            val = val.split(":");
            return (parseInt(val[0]) > 19) ? "HZ:M0" : "H0:M0";
        }

        pattern = {
            onKeyPress: function(val, e, field, options) {
                field.mask(mask.apply({}, arguments), options);
            },
            translation: {
                'H': {
                    pattern: /[0-2]/,
                    optional: false
                },
                'Z': {
                    pattern: /[0-3]/,
                    optional: false
                },
                'M': {
                    pattern: /[0-5]/,
                    optional: false
                }
            },
            placeholder: 'Hora:minutos'
        };

        $(document).ready(function() {
            $("#hora").mask(mask, pattern);
        });


        // Inseri máscara no CEP
        $("#cep").inputmask({
            mask: ["99999-999", ],
            keepStatic: true
        });

    </script>
@endsection
