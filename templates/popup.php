<script>window.ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
<div class="product-restriction-by-postcode" data-popup <?php if(isset($_SESSION['product_restriction_by_postcode']) && !empty($_SESSION['product_restriction_by_postcode'])): ?>style="display:none"<?php endif; ?>>
  <div class="overlay"></div>
  <div class="box">
    <strong>Onde você está?</strong>
    <p>Dessa forma você terá acesso aos produtos e ofertas da sua região</p>
    <span>Digite abaixo o seu CEP</span>
    <input maxlength="8" type="text" name="postcode" placeholder="Digite o CEP e pressione enter">
    <button>Confirmar</button>
  </div>
</div>