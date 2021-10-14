<?php if(defined('RESTRICTED')): ?>
<div class="restringir-produto-por-cep-alert">
<?php echo __('<strong>Atenção!</strong> Este produto não está disponível para entrega e por isso a calculadora de frete está desativada. <a href="#" id="popupcep">CLIQUE AQUI</a> para mudar o CEP.', 'restringir-produto-por-cep'); ?>
</div>
<style>#shipping-simulator{display:none}</style>
<?php endif; ?>