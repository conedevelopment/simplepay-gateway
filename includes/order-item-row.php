<?php if ($order->get_payment_method() === 'simplepay-gateway'): ?>
    <tr scope="row">
        <th><?php _e('SimplePay transaction ID'); ?>:</th>
        <td><strong><?php echo $order->get_transaction_id(); ?></strong></td>
    </tr>
<?php endif; ?>
