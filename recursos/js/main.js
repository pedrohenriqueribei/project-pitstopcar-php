$(function(){
    $(document).ready(function(){
        $('#telefone').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');
        $('#placa').mask('AAA-9A99');
        $('#valor').mask('#.##0,00', {reverse: true});
        $('#preco').mask('#.##0,00', {reverse: true});
        $('#desconto').mask('#.##0,00', {reverse: true});
        $('#taxa_entrega').mask('#.##0,00', {reverse: true});
        $('#renavam').mask('99999999999');
        $('#quilometragem').mask('##9.999', {reverse: true});
        $('#cpf').mask('000.000.000-00');
        $('#cnpj').mask('00.000.000/0000-00');
        $('#rg').mask('00.000.000-0');
        $('#perc_lucro').mask('##0,00', {reverse: true});
    });
});

$("#placa").keyup(function (e) {

    var this2 = $('#placa').val().toUpperCase();

     $('#placa').val(this2);

 });