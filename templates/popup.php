<script>window.ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
<div class="restringir-produto-por-cep" data-popup <?php if (WC()->customer->get_billing_postcode()): ?>style="display:none"<?php endif; ?>>
  <div class="overlay"></div>
  <div class="box">
    <strong><?php echo __('Onde você está?', 'restringir-produto-por-cep'); ?></strong>
    <p><?php echo __('Dessa forma você terá acesso aos produtos e ofertas da sua região', 'restringir-produto-por-cep'); ?></p>
    <span><?php echo __('Digite abaixo o seu CEP', 'restringir-produto-por-cep'); ?></span>
    <input maxlength="9" inputmode="numeric" pattern="[\d]{8}-[\d]{3}" type="text" name="postcode" placeholder="<?php echo __('Digite o CEP e pressione enter', 'restringir-produto-por-cep'); ?>">
    <button><?php echo __('Confirmar', 'restringir-produto-por-cep'); ?></button>
  </div>
</div>