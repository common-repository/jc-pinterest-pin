<div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div>
    <h2>Pinterest Settings</h2>
<br/>

<form action="" method="post">
    <table>
    <tr>
        <td width="190"> Pinterest button size:</td> 
        <td>
           <select name="pin_button_size" id="pin_button_size">
               <option value="20" <?php if($result['pin_button_size'] == 20)echo 'selected="selected"'; ?>>small</option>
               <option value="28" <?php if($result['pin_button_size'] == 28)echo 'selected="selected"'; ?>>large</option>
           </select> 
       </td>
    </tr>
    <tr>
        <td width="190"> Pinterest button shape:</td> 
        <td>
            <select name="pin_button_shape" id="pin_button_shape">
                <option value="rectangular" <?php if($result['pin_button_shape'] == 'rectangular')echo 'selected="selected"'; ?>>Rectangular</option>
                <option value="circular" <?php if($result['pin_button_shape'] == 'circular')echo 'selected="selected"'; ?>>Circular</option>

            </select>
        </td>
    </tr>

    <tr>
        <td width="190">Pinterest pin Count:</td> 
        <td>
            <select name="pin_count" id="pin_count">
                <option value="no" <?php if($result['pin_count'] == 'no')echo 'selected="selected"'; ?>>Don't Show</option>
                <option value="above" <?php if($result['pin_count'] == 'above')echo 'selected="selected"'; ?>>Above button</option>
                <option value="beside" <?php if($result['pin_count'] == 'beside')echo 'selected="selected"'; ?>>Beside button</option>
            </select>

        </td>
    </tr>

    <tr>
        <td width="190" style="text-align:left;">
            <input type="hidden" name="action" value="addpin">
            <input type="submit" class="button button-primary button-large" name="submit" value="Submit">
        </td>     
    </tr>

    </table>
    <br/>
    <p>Use the shortcode <b style="color:red">  [jc-pin]  </b> anywhere on the page, post to get the skype addon into action.</p>
    <p> To use the shortcode directly on theme file for eg. in header.php use place the following code 
        <?php  highlight_string("<?php echo do_shortcode['jc-pin']; ?>");?>
    </p>
</form>
</div>


<div class="donate" style="margin-top: 40px;margin-right:30px;float:right;">
<p style="font-weight: bold;">Donate and help us keep going on</p>
    <form action="https://www.moneybookers.com/app/payment.pl" method="post" target="_blank">
    <input type="hidden" name="pay_to_email" value="obsession.raj@gmail.com" />
    <input type="hidden" name="language" value="EN" />
    <select name="currency" size="1">
    <option value="USD">US dollar</option>
    </select>
    Amount:<input type="text" name="amount" value="2.00" size="10" />
    <p><input type="image" alt="click to make a donation to help us continue" value="Donate!" height="80" src="<?php echo plugins_url(); ?>/jc-pinterest-pin/images/donate.jpg" width="150" /></p>
    <input type="hidden" name="detail1_description" value="donation to contributer rajiv-jyasha" />
    <input type="hidden" name="detail1_text" value="donation to contributer rajiv-jyasha" />
</form>
</div>
