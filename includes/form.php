<!-- Overlay -->
<div class="payment-overlay">
    <div class="payment-loading-text">
        <h1><?php _e('We are redirecting you to the payment page!', 'pine-simplepay'); ?></h1>
    </div>
    <div class="payment-loader"></div>
</div>

<!-- Form -->
<form
    method="POST"
    style="display: none;"
    accept-charset="utf-8"
    action="<?php echo $payment->getUrl(); ?>"
    name="<?php echo ($id = md5(time().mt_rand())); ?>"
>
    <?php foreach ($payment->getPayload() as $key => $item): ?>
        <?php if (is_array($item)): ?>
            <?php foreach ($item as $value): ?>
                <input type="hidden" name="<?php echo $key; ?>[]" value="<?php echo $value; ?>" readonly>
            <?php endforeach; ?>
        <?php else: ?>
            <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $item; ?>" readonly>
        <?php endif; ?>
    <?php endforeach; ?>
</form>

<!-- Script -->
<script>
    document.querySelector('#order_review').addEventListener('submit', function (event) {
        if (document.querySelector('input[name="payment_method"]:checked').value === 'pine-simplepay') {
            event.preventDefault();
        }
    });

    document.querySelector('form[name="<?php echo $id; ?>"]').submit();
</script>
