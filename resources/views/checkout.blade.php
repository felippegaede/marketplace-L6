@extends('layouts.front')

@section('stylesheets')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')

<div class="container">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <h2>Dados do Cartão de Crédito</h2>
                <hr>
            </div>
        </div>
        <form action="" method="post">
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="">Nome impresso no cartão</span></label>
                    <input type="text" class="form-control" name="card_name">
                </div>
                <div class="col-md-12 form-group">
                    <label for="">Número do Cartão <span class="brand"></span></label>
                    <input type="text" class="form-control" name="card_number">
                    <input type="hidden" class="form-control" name="card_brand">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="">Mês</label>
                    <input type="text" class="form-control" name="card_month">
                </div>
                <div class="col-md-4 form-group">
                    <label for="">Ano</label>
                    <input type="text" class="form-control" name="card_year">
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 form-group">
                    <label for="">CVV</label>
                    <input type="text" class="form-control" name="card_cvv">
                </div>
                <div class="col-md-12 installments form-group"></div>
            </div>
            <button type="submit" class="btn btn-success btn-lg processCheckout">Confirmar Pagamento</button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    const sessionId = '{{session()->get("pagseguro_session_code")}}';

    PagSeguroDirectPayment.setSessionId(sessionId);

</script>
<script>
    let amountTransaction = '{{$cartItems}}';
    let cardNumber = document.querySelector('input[name=card_number]');
    let spanBrand = document.querySelector('span.brand')
    cardNumber.addEventListener('keyup', function(){

        if(cardNumber.value.length >= 6){

            PagSeguroDirectPayment.getBrand({
            cardBin: cardNumber.value.substr(0,6),
            success: function(response) {

                let imgFlag = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${response.brand.name}.png" />`
                spanBrand.innerHTML = imgFlag;
                document.querySelector('input[name=card_brand]').value = response.brand.name;
                getInstallment(amountTransaction, response.brand.name);

            },
            error: function(response) {
                console.log(response);
            },
            complete: function(response) {
            }

            });
        }
    });

    let submitButton = document.querySelector('button.processCheckout');


    submitButton.addEventListener('click', function(event){

        event.preventDefault();

        PagSeguroDirectPayment.createCardToken({

            cardNumber: document.querySelector('input[name=card_number]').value,
            brand: document.querySelector('input[name=card_brand]').value,
            cvv: document.querySelector('input[name=card_cvv]').value,
            expirationMonth: document.querySelector('input[name=card_month]').value,
            expirationYear: document.querySelector('input[name=card_year]').value,
            success: function(response) {

                processPayment(response.card.token)
            },
            error: function(response) {

                console.log(response);
            },
            complete: function(response) {
            }
        });
    });

    function getInstallment(amount, brand){
        PagSeguroDirectPayment.getInstallments({
            amount: amount,
            maxInstallmentNoInterest: 3,
            brand: brand,
            success: function(response){

                let selectInstallments = drawSelectInstallments(response.installments[brand]);
                document.querySelector('div.installments').innerHTML = selectInstallments;

            },
            error: function(response) {
                // callback para chamadas que falharam.
            },
            complete: function(response){
                // Callback para todas chamadas.
            }
        });
    }

    function processPayment(token)
    {
        let hash = PagSeguroDirectPayment.getSenderHash();

        let data = {

            card_token: token,
            hash: hash,
            installment: document.querySelector('#select_installments').value,
            card_name: document.querySelector('input[name=card_name]').value,
            _token:"{{csrf_token()}}",

        };

        $.ajax({

            url:'{{route("checkout.process")}}',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (response){

                toastr.success(response.data.message, 'Sucesso')
                window.location.href = '{{route('checkout.thanks')}}?order=' + response.data.order;
            }

        });
    }


    function drawSelectInstallments(installments) {
		let select = '<label>Opções de Parcelamento:</label>';

		select += '<select class="form-control" id="select_installments">';
            console.log(installments);
		for(let l of installments) {
		    select += `<option value="${l.quantity}|${l.installmentAmount}">${l.quantity}x R$ ${l.installmentAmount} - Total: R$ ${l.totalAmount}</option>`;
		}


		select += '</select>';

		return select;
	}
</script>
@endsection
