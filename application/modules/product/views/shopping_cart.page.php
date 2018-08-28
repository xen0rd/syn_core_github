

<?= link_tag(css_url() . "cart.css") ?>
<div class="cart-button">
    <span class="label label-danger">
        <?=isset($cart) ? sizeof($cart) : "0"?>
    </span>
    <a href="#"><span class="fa fa-2x fa-shopping-cart cart-icon"></span></a>
</div>

<div id="cart-content" class="collapse">
    <div class="modal-header">
        <button id="cart-close" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>Shopping Cart</h4>
    </div>
    <div class="table-responsive">
        <table id="cartTable" class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
<!--                    <th>Quantity</th>-->
                    <th>Sub Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($cart))
                {
                    $total = 0;
                    foreach ($cart as $key => $val)
                    {
                        $total += $val['sub_total'];
                        ?>
                        <tr>
                            <td><?= $val['item_name'] ?></td>
                            <td>$<?= $val['price'] ?></td>
<!--                            <td>
                                <input type="number" min="0" class="form-control itemQuantity" value="<?= $val['quantity'] ?>"> &nbsp;
                                <a href="<?= base_url() . 'product/updateCart/' . $val['id'] ?>/" class="btn btn-success" title="Update" disabled><span class="fa fa-refresh"></span></button>
                            </td>-->
                            <td>$<?= $val['sub_total'] ?></td>
                            <td>
                                <a href="<?= base_url() . 'product/removeItem/' . $val['id'] ?>" class="btn btn-danger" title="Remove"><span class="fa fa-minus"></span></button>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td><a href="<?= base_url() . "product/emptyCart" ?>" class="btn btn-warning">Empty Cart</a></td>
                    <td></td>
<!--                    <td></td>-->
                    <td>Total: <b>$<?= $total ?? "0" ?></b></td>
                    <td>
                        <br>
                        <br>
                <?php
                if(_SYNTHIA_PRO){ ?>
                        <div id="submitCartProDiv">
                            <input id="submitCartPro" type="button" style="float:right;" class="btn btn-success" value="Checkout" <?= @$total > 0 ? '' : 'disabled'?>>
                        </div>
                <?php } else{ ?>
                        <form id="submitCart" action="<?=_PAYPAL_PAYMENTS_URL?>" method="post">
                            <input type="hidden" name="cmd" value="_cart">
                            <input type="hidden" name="upload" value="1">
                            <input type="hidden" name="business" value="<?=$payment_method->business_email?>">
                            <input type="hidden" name="custom" value='{"user_id" : "<?= @$this->session->userdata('c_id')?>" , "guest_email" : "<?= @$this->session->userdata('guest_email')?>"}'>
                            <?php
                            if (isset($cart))
                            {
                                $count = 1;
                                foreach ($cart as $key => $val)
                                {
                                    ?>
                                    <input type="hidden" name="item_number_<?= $count ?>" value="<?= $val['id']; ?>">
                                    <input type="hidden" name="amount_<?= $count ?>" value="<?= $val['price']; ?>">
                                    <input type="hidden" name="item_name_<?= $count ?>" value="<?= $val['item_name']; ?>">
                                    <input type="hidden" name="quantity_<?= $count ?>" value="1">
<!--                                    <input type="hidden" name="quantity_<?= $count ?>" value="<?= $val['quantity'] ?>">-->
                                    <?php $count++;
                                }
                                ?>
                            <?php } ?>
                            <input type="submit" style="float:right;" class="btn btn-success" value="Checkout">
                        </form> 
                    <?php } ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="modal fade" id="guest_email_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Guest Email</h4>
            </div>
            <div class="modal-body">
                <p><i>Please enter your email address to proceed to checkout</i></p>
                <label for="guest_email" class="label label-primary">Email</label>
                <input id="guest_email" type="text" name="guest_email" class="form-control" required autofocus>
                <p id="guest_error" style="color:red;"></p>
            </div>
            <div class="modal-footer">
                <button id="submitGuestEmail" type="button" class="btn btn-default">Ok</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="billing_info_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Billing Information</h4>
            </div>
            <form id="submitCart" action="<?=base_url()?>product/paypalPaymentsPro" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email" class="label label-primary">Email</label>
                        <input id="email" type="text" name="email" class="form-control" <?= null !== $this->session->userdata('c_id') ? 'readonly value="' . $this->session->userdata('c_email') . '"' : ''?>required autofocus>
                        <input id="is_guest" type="hidden" name="is_guest" value="<?= null !== $this->session->userdata('c_id') ? 0 : 1?>">
                    </div>
                    <div class="form-group">
                        <label for="first_name" class="label label-primary">First Name</label>
                        <input id="first_name" type="text" name="first_name" class="form-control" <?= null !== $this->session->userdata('c_id') ? 'readonly value="' . $this->session->userdata('c_first_name') . '"' : ''?>>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="label label-primary">Last Name</label>
                        <input id="last_name" type="text" name="last_name" class="form-control" <?= null !== $this->session->userdata('c_id') ? 'readonly value="' . $this->session->userdata('c_last_name') . '"' : ''?>>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="card_type" class="label label-primary">Card Type:</label>
                        <select id="card_type" name="card_type" class="form-control" required>
                            <option value="Visa">Visa</option>
                            <option value="MasterCard">MasterCard</option>
                            <option value="Discover">Discover</option>
                            <option value="Amex">Amex</option>
                            <option value="JCB">JCB</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="account_number" class="label label-primary">Account Number:</label>
                        <input id="account_number" type="text" name="account_number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="expiry_date" class="label label-primary">Expiry Date:</label>
                        <input id="expiry_date" type="text" name="expiry_date" class="form-control" required>
                        <p id="guest_error" style="color:red;"></p>
                    </div>
                    <div class="form-group">
                        <label for="cvv" class="label label-primary">CVV:</label>
                        <input id="cvv" type="text" name="cvv" class="form-control" required>
                        <p id="guest_error" style="color:red;"></p>
                    </div>
                    <div class="form-group">
                        <label for="street" class="label label-primary">Street:</label>
                        <input id="street" type="text" name="street" class="form-control" required>
                        <p id="guest_error" style="color:red;"></p>
                    </div>
                    <div class="form-group">
                        <label for="city" class="label label-primary">City:</label>
                        <input id="city" type="text" name="city" class="form-control" required>
                        <p id="guest_error" style="color:red;"></p>
                    </div>
                    <div class="form-group">
                        <label for="state" class="label label-primary">State:</label>
                        <select name="state" id="state" class="form-control" required>
                            <option disabled selected value="">Please select</option>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                            <option value="GU">Guam</option>
                            <option value="PR">Puerto Rico</option>
                            <option value="VI">Virgin Islands</option>
                        </select>
                        <p id="guest_error" style="color:red;"></p>
                    </div>
                    <div class="form-group">
                        <label for="zip" class="label label-primary">ZIP:</label>
                        <input id="zip" type="text" name="zip" class="form-control" required>
                        <p id="guest_error" style="color:red;"></p>
                    </div>
                    <div class="form-group">
                        <label for="country" class="label label-primary">Country :</label>
                        <select name="country" id="country" class="form-control" required>
                            <option disabled selected value="">Please select</option>
                            <option value="AL">Albania</option>
                            <option value="DZ">Algeria</option>
                            <option value="AD">Andorra</option>
                            <option value="AO">Angola</option>
                            <option value="AI">Anguilla</option>
                            <option value="AG">Antigua and Barbuda</option>
                            <option value="AR">Argentina</option>
                            <option value="AM">Armenia</option>
                            <option value="AW">Aruba</option>
                            <option value="AU">Australia</option>
                            <option value="AT">Austria</option>
                            <option value="AZ">Azerbaijan</option>
                            <option value="BS">Bahamas</option>
                            <option value="BH">Bahrain</option>
                            <option value="BB">Barbados</option>
                            <option value="BY">Belarus</option>
                            <option value="BE">Belgium</option>
                            <option value="BZ">Belize</option>
                            <option value="BJ">Benin</option>
                            <option value="BM">Bermuda</option>
                            <option value="BT">Bhutan</option>
                            <option value="BO">Bolivia</option>
                            <option value="BA">Bosnia and Herzegovina</option>
                            <option value="BW">Botswana</option>
                            <option value="BR">Brazil</option>
                            <option value="VG">British Virgin Islands</option>
                            <option value="BN">Brunei</option>
                            <option value="BG">Bulgaria</option>
                            <option value="BF">Burkina Faso</option>
                            <option value="BI">Burundi</option>
                            <option value="KH">Cambodia</option>
                            <option value="CM">Cameroon</option>
                            <option value="CA">Canada</option>
                            <option value="CV">Cape Verde</option>
                            <option value="KY">Cayman Islands</option>
                            <option value="TD">Chad</option>
                            <option value="CL">Chile</option>
                            <option value="C2">China</option>
                            <option value="CO">Colombia</option>
                            <option value="KM">Comoros</option>
                            <option value="CG">Congo - Brazzaville</option>
                            <option value="CD">Congo - Kinshasa</option>
                            <option value="CK">Cook Islands</option>
                            <option value="CR">Costa Rica</option>
                            <option value="CI">Cote d'Ivoire</option>
                            <option value="HR">Croatia</option>
                            <option value="CY">Cyprus</option>
                            <option value="CZ">Czech Republic</option>
                            <option value="DK">Denmark</option>
                            <option value="DJ">Djibouti</option>
                            <option value="DM">Dominica</option>
                            <option value="DO">Dominican Republic</option>
                            <option value="EC">Ecuador</option>
                            <option value="EG">Egypt</option>
                            <option value="SV">El Salvador</option>
                            <option value="ER">Eritrea</option>
                            <option value="EE">Estonia</option>
                            <option value="ET">Ethiopia</option>
                            <option value="FK">Falkland Islands</option>
                            <option value="FO">Faroe Islands</option>
                            <option value="FJ">Fiji</option>
                            <option value="FI">Finland</option>
                            <option value="FR">France</option>
                            <option value="GF">French Guiana</option>
                            <option value="PF">French Polynesia</option>
                            <option value="GA">Gabon</option>
                            <option value="GM">Gambia</option>
                            <option value="GE">Georgia</option>
                            <option value="DE">Germany</option>
                            <option value="GI">Gibraltar</option>
                            <option value="GR">Greece</option>
                            <option value="GL">Greenland</option>
                            <option value="GD">Grenada</option>
                            <option value="GP">Guadeloupe</option>
                            <option value="GT">Guatemala</option>
                            <option value="GN">Guinea</option>
                            <option value="GW">Guinea-Bissau</option>
                            <option value="GY">Guyana</option>
                            <option value="HN">Honduras</option>
                            <option value="HK">Hong Kong</option>
                            <option value="HU">Hungary</option>
                            <option value="IS">Iceland</option>
                            <option value="IN">India</option>
                            <option value="ID">Indonesia</option>
                            <option value="IE">Ireland</option>
                            <option value="IL">Israel</option>
                            <option value="IT">Italy</option>
                            <option value="JM">Jamaica</option>
                            <option value="JP">Japan</option>
                            <option value="JO">Jordan</option>
                            <option value="KZ">Kazakhstan</option>
                            <option value="KE">Kenya</option>
                            <option value="KI">Kiribati</option>
                            <option value="KW">Kuwait</option>
                            <option value="KG">Kyrgyzstan</option>
                            <option value="LA">Laos</option>
                            <option value="LV">Latvia</option>
                            <option value="LS">Lesotho</option>
                            <option value="LI">Liechtenstein</option>
                            <option value="LT">Lithuania</option>
                            <option value="LU">Luxembourg</option>
                            <option value="MK">Macedonia</option>
                            <option value="MG">Madagascar</option>
                            <option value="MW">Malawi</option>
                            <option value="MY">Malaysia</option>
                            <option value="MV">Maldives</option>
                            <option value="ML">Mali</option>
                            <option value="MT">Malta</option>
                            <option value="MH">Marshall Islands</option>
                            <option value="MQ">Martinique</option>
                            <option value="MR">Mauritania</option>
                            <option value="MU">Mauritius</option>
                            <option value="YT">Mayotte</option>
                            <option value="MX">Mexico</option>
                            <option value="FM">Micronesia</option>
                            <option value="MD">Moldova</option>
                            <option value="MC">Monaco</option>
                            <option value="MN">Mongolia</option>
                            <option value="ME">Montenegro</option>
                            <option value="MS">Montserrat</option>
                            <option value="MA">Morocco</option>
                            <option value="MZ">Mozambique</option>
                            <option value="NA">Namibia</option>
                            <option value="NR">Nauru</option>
                            <option value="NP">Nepal</option>
                            <option value="NL">Netherlands</option>
                            <option value="NC">New Caledonia</option>
                            <option value="NZ">New Zealand</option>
                            <option value="NI">Nicaragua</option>
                            <option value="NE">Niger</option>
                            <option value="NG">Nigeria</option>
                            <option value="NU">Niue</option>
                            <option value="NF">Norfolk Island</option>
                            <option value="NO">Norway</option>
                            <option value="OM">Oman</option>
                            <option value="PW">Palau</option>
                            <option value="PA">Panama</option>
                            <option value="PG">Papua New Guinea</option>
                            <option value="PY">Paraguay</option>
                            <option value="PE">Peru</option>
                            <option value="PH">Philippines</option>
                            <option value="PN">Pitcairn Islands</option>
                            <option value="PL">Poland</option>
                            <option value="PT">Portugal</option>
                            <option value="QA">Qatar</option>
                            <option value="RE">Reunion</option>
                            <option value="RO">Romania</option>
                            <option value="RU">Russia</option>
                            <option value="RW">Rwanda</option>
                            <option value="WS">Samoa</option>
                            <option value="SM">San Marino</option>
                            <option value="ST">Sao Tome and Principe</option>
                            <option value="SA">Saudi Arabia</option>
                            <option value="SN">Senegal</option>
                            <option value="RS">Serbia</option>
                            <option value="SC">Seychelles</option>
                            <option value="SL">Sierra Leone</option>
                            <option value="SG">Singapore</option>
                            <option value="SK">Slovakia</option>
                            <option value="SI">Slovenia</option>
                            <option value="SB">Solomon Islands</option>
                            <option value="SO">Somalia</option>
                            <option value="ZA">South Africa</option>
                            <option value="KR">South Korea</option>
                            <option value="ES">Spain</option>
                            <option value="LK">Sri Lanka</option>
                            <option value="SH">St. Helena</option>
                            <option value="KN">St. Kitts and Nevis</option>
                            <option value="LC">St. Lucia</option>
                            <option value="PM">St. Pierre and Miquelon</option>
                            <option value="VC">St. Vincent and Grenadines</option>
                            <option value="SR">Suriname</option>
                            <option value="SJ">Svalbard and Jan Mayen</option>
                            <option value="SZ">Swaziland</option>
                            <option value="SE">Sweden</option>
                            <option value="CH">Switzerland</option>
                            <option value="TW">Taiwan</option>
                            <option value="TJ">Tajikistan</option>
                            <option value="TZ">Tanzania</option>
                            <option value="TH">Thailand</option>
                            <option value="TG">Togo</option>
                            <option value="TO">Tonga</option>
                            <option value="TT">Trinidad and Tobago</option>
                            <option value="TN">Tunisia</option>
                            <option value="TM">Turkmenistan</option>
                            <option value="TC">Turks and Caicos Islands</option>
                            <option value="TV">Tuvalu</option>
                            <option value="UG">Uganda</option>
                            <option value="UA">Ukraine</option>
                            <option value="AE">United Arab Emirates</option>
                            <option value="GB">United Kingdom</option>
                            <option value="US">United States</option>
                            <option value="UY">Uruguay</option>
                            <option value="VU">Vanuatu</option>
                            <option value="VA">Vatican City</option>
                            <option value="VE">Venezuela</option>
                            <option value="VN">Vietnam</option>
                            <option value="WF">Wallis and Futuna</option>
                            <option value="YE">Yemen</option>
                            <option value="ZM">Zambia</option>
                            <option value="ZW">Zimbabwe</option>
                        </select>
                    </div>
                    <input type="hidden" name="total_amount" value="<?=$total?>">
                    <?php
                        if (isset($cart))
                        {
                            $count = 0;
                            foreach ($cart as $key => $val)
                            { ?>
                                <input type="hidden" name="L_NUMBER<?= $count ?>" value="<?= $val['id']; ?>">
                                <input type="hidden" name="L_AMT<?= $count ?>" value="<?= $val['price']; ?>">
                                <input type="hidden" name="L_NAME<?= $count ?>" value="<?= $val['item_name']; ?>">
                                <input type="hidden" name="L_QTY<?= $count ?>" value="1">
                                <?php $count++;
                            } ?>
                    <?php } ?>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default">Ok</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#submitCartProDiv").on("click", "input", function(){
        $("#billing_info_modal").modal('show'); 
    });
</script>
<script>
    $(function () {
        var obj = $.parseJSON($("input[name=custom]").val());
        
        $("#submitCart").submit(function (e) {
            e.preventDefault();
            
            if (obj.user_id == "" && obj.guest_email == "")
            {
                $("#guest_email_modal").modal('show');  
            }
            else
            {
                $(this)[0].submit();
            }
        });

        $("#submitGuestEmail").click(function(){
            var guestEmail = $("#guest_email").val();
            $(this).attr('disabled', 'disabled');
            
            if(validateEmail(guestEmail) === true){
                $("#guest_error").text('');
                obj.guest_email = guestEmail;
                $("input[name=custom]").val(JSON.stringify(obj));
                 $.ajax({
                    url: '<?php echo site_url("product/guestEmail")?>',
                    type: 'POST',
                    data: {'email' : guestEmail},
                    success: function(){
                        $("#submitCart")[0].submit();
                    }
                });
            }
            else{
                $(this).attr('disabled', false);
                $("#guest_error").text('Please enter a valid email address');
            }
        });
        

        function validateEmail(sEmail) {
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (filter.test(sEmail))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    });
</script>