<style>
    .text-danger.fa.fa-asterisk.required{
        top: 8px;
        right: -23px;
        font-size: 8px;
    }
</style>
<div class="container">
	<?=form_open(current_url(), 'id=client_form autocomplete="off"')?>
		<div class="row">
			<div class="col-md-6">
				<fieldset>
					<legend>Account information</legend>
					<div class="form-group has-feedback">
                                                <i class="text-danger fa fa-asterisk form-control-feedback required"></i>
						<label for="username" class="label label-primary">Username</label>
						<input type="text" name="username" id="username" class="form-control" value="<?=set_value('username')?>">
						<small class="text-muted">4 - 20 alphanumeric characters</small>
						<?=form_error('username');?>
					</div>
					<div class="form-group has-feedback">
                                                <i class="text-danger fa fa-asterisk form-control-feedback required"></i>
						<label for="password" class="label label-primary">Password</label>
						<input type="password" name="password" id="password" class="form-control required" value="<?=set_value('password')?>">
						<small class="text-muted">8 - 20 alphanumeric characters</small>
						<?=form_error('password');?>
					</div>			
					<div class="form-group has-feedback">
                                                <i class="text-danger fa fa-asterisk form-control-feedback required"></i>
						<label for="confirm_password" class="label label-primary">Confirm password</label>
						<input type="password" name="confirm_password" id="confirm_password" class="form-control required" value="<?=set_value('confirm_password')?>">
						<?=form_error('confirm_password');?>
					</div>
					<div class="form-group has-feedback">
                                                <i class="text-danger fa fa-asterisk form-control-feedback required"></i>
						<label for="security_question_id" class="label label-primary">Security question</label>
						<select name="security_question_id" id="security_question_id" class="form-control required">
							<option disabled selected>Please select</option>
							<option value="1" <?=set_select("security_question_id", 1) ?>>What is your first pet's name?</option>
							<option value="2" <?=set_select("security_question_id", 2) ?>>In what city or town does your nearest sibling live?</option>
							<option value="3" <?=set_select("security_question_id", 3) ?>>What was the name of your elementary / primary school?</option>
						</select>
						<?=form_error('security_question_id');?>
					</div>
					<div class="form-group has-feedback">
                                                <i class="text-danger fa fa-asterisk form-control-feedback required"></i>
						<label for="security_answer" class="label label-primary">Security answer</label>
						<input type="password" name="security_answer" id="security_answer" class="form-control required" value="<?=set_value('security_answer')?>">
						<?=form_error('security_answer');?>
					</div>
				</fieldset>
			</div>
		</div>
		<br>
		<fieldset>
			<legend>Personal information</legend>
			<div class="row">
				<div class="col-md-6">		
					<div class="form-group has-feedback">
                                                <i class="text-danger fa fa-asterisk form-control-feedback required"></i>
						<label for="first_name" class="label label-primary">First name</label>
						<input type="text" name="first_name" id="first_name" class="form-control" value="<?=set_value('first_name')?>">
						<?=form_error('first_name');?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group has-feedback">
                                                <i class="text-danger fa fa-asterisk form-control-feedback required"></i>
						<label for="last_name" class="label label-primary">Last name</label>
						<input type="text" name="last_name" id="last_name" class="form-control" value="<?=set_value('last_name')?>">
						<?=form_error('last_name');?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">	
					<div class="form-group has-feedback">
                                                <i class="text-danger fa fa-asterisk form-control-feedback required"></i>
						<label for="new_email" class="label label-primary">Email</label>
						<input type="text" name="new_email" id="new_email" class="form-control" value="<?=set_value('new_email')?>">
						<?=form_error('new_email');?>
					</div>
				</div>
				<div class="col-md-6">	
                                    <div class="form-group has-feedback">
                                            <i class="text-danger fa fa-asterisk form-control-feedback required"></i>
                                            <label for="date_of_birth" class="label label-primary">Date of birth</label>
                                            <div class="input-group date">
                                                <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" value="<?=set_value('date_of_birth')?>">
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-th"></span>
                                                </div>
                                            </div>
                                            <?=form_error('date_of_birth');?>
                                    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">	
					<div class="form-group">
						<label for="current_address" class="label label-primary">Current address</label>
						<input type="text" name="current_address" id="current_address" class="form-control" value="<?=set_value('current_address')?>">
						<?=form_error('current_address');?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="permanent_address" class="label label-primary">Permanent address</label>
						<input type="text" name="permanent_address" id="permanent_address" class="form-control" value="<?=set_value('permanent_address')?>">
						<small class="text-muted">Fill only if not the same as current address</small>
						<?=form_error('permanent_address');?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="state" class="label label-primary">State</label>
						<input type="text" name="state" id="state" class="form-control" value="<?=set_value('state')?>">
						<?=form_error('state');?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="postal_code" class="label label-primary">Postal code</label>
						<input type="text" name="postal_code" id="postal_code" class="form-control" value="<?=set_value('postal_code')?>">
						<?=form_error('postal_code');?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="country_code" class="label label-primary">Country</label>
						<select name="country_code" id="country_code" class="form-control">
							<option disabled selected>Please select</option>
							<option value="AL" <?=set_select("country_code", "AL") ?>>Albania</option>
							<option value="DZ" <?=set_select("country_code", "DZ") ?>>Algeria</option>
							<option value="AD" <?=set_select("country_code", "AD") ?>>Andorra</option>
							<option value="AO" <?=set_select("country_code", "AO") ?>>Angola</option>
							<option value="AI" <?=set_select("country_code", "AI") ?>>Anguilla</option>
							<option value="AG" <?=set_select("country_code", "AG") ?>>Antigua and Barbuda</option>
							<option value="AR" <?=set_select("country_code", "AR") ?>>Argentina</option>
							<option value="AM" <?=set_select("country_code", "AM") ?>>Armenia</option>
							<option value="AW" <?=set_select("country_code", "AW") ?>>Aruba</option>
							<option value="AU" <?=set_select("country_code", "AU") ?>>Australia</option>
							<option value="AT" <?=set_select("country_code", "AT") ?>>Austria</option>
							<option value="AZ" <?=set_select("country_code", "AZ") ?>>Azerbaijan</option>
							<option value="BS" <?=set_select("country_code", "BS") ?>>Bahamas</option>
							<option value="BH" <?=set_select("country_code", "BH") ?>>Bahrain</option>
							<option value="BB" <?=set_select("country_code", "BB") ?>>Barbados</option>
							<option value="BY" <?=set_select("country_code", "BY") ?>>Belarus</option>
							<option value="BE" <?=set_select("country_code", "BE") ?>>Belgium</option>
							<option value="BZ" <?=set_select("country_code", "BZ") ?>>Belize</option>
							<option value="BJ" <?=set_select("country_code", "BJ") ?>>Benin</option>
							<option value="BM" <?=set_select("country_code", "BM") ?>>Bermuda</option>
							<option value="BT" <?=set_select("country_code", "BT") ?>>Bhutan</option>
							<option value="BO" <?=set_select("country_code", "BO") ?>>Bolivia</option>
							<option value="BA" <?=set_select("country_code", "BA") ?>>Bosnia and Herzegovina</option>
							<option value="BW" <?=set_select("country_code", "BW") ?>>Botswana</option>
							<option value="BR" <?=set_select("country_code", "BR") ?>>Brazil</option>
							<option value="VG" <?=set_select("country_code", "VG") ?>>British Virgin Islands</option>
							<option value="BN" <?=set_select("country_code", "BN") ?>>Brunei</option>
							<option value="BG" <?=set_select("country_code", "BG") ?>>Bulgaria</option>
							<option value="BF" <?=set_select("country_code", "BF") ?>>Burkina Faso</option>
							<option value="BI" <?=set_select("country_code", "BI") ?>>Burundi</option>
							<option value="KH" <?=set_select("country_code", "KH") ?>>Cambodia</option>
							<option value="CM" <?=set_select("country_code", "CM") ?>>Cameroon</option>
							<option value="CA" <?=set_select("country_code", "CA") ?>>Canada</option>
							<option value="CV" <?=set_select("country_code", "CV") ?>>Cape Verde</option>
							<option value="KY" <?=set_select("country_code", "KY") ?>>Cayman Islands</option>
							<option value="TD" <?=set_select("country_code", "TD") ?>>Chad</option>
							<option value="CL" <?=set_select("country_code", "CL") ?>>Chile</option>
							<option value="C2" <?=set_select("country_code", "C2") ?>>China</option>
							<option value="CO" <?=set_select("country_code", "CO") ?>>Colombia</option>
							<option value="KM" <?=set_select("country_code", "KM") ?>>Comoros</option>
							<option value="CG" <?=set_select("country_code", "CG") ?>>Congo - Brazzaville</option>
							<option value="CD" <?=set_select("country_code", "CD") ?>>Congo - Kinshasa</option>
							<option value="CK" <?=set_select("country_code", "CK") ?>>Cook Islands</option>
							<option value="CR" <?=set_select("country_code", "CR") ?>>Costa Rica</option>
							<option value="CI" <?=set_select("country_code", "CI") ?>>Cote d'Ivoire</option>
							<option value="HR" <?=set_select("country_code", "HR") ?>>Croatia</option>
							<option value="CY" <?=set_select("country_code", "CY") ?>>Cyprus</option>
							<option value="CZ" <?=set_select("country_code", "CZ") ?>>Czech Republic</option>
							<option value="DK" <?=set_select("country_code", "DK") ?>>Denmark</option>
							<option value="DJ" <?=set_select("country_code", "DJ") ?>>Djibouti</option>
							<option value="DM" <?=set_select("country_code", "DM") ?>>Dominica</option>
							<option value="DO" <?=set_select("country_code", "DO") ?>>Dominican Republic</option>
							<option value="EC" <?=set_select("country_code", "EC") ?>>Ecuador</option>
							<option value="EG" <?=set_select("country_code", "EG") ?>>Egypt</option>
							<option value="SV" <?=set_select("country_code", "SV") ?>>El Salvador</option>
							<option value="ER" <?=set_select("country_code", "ER") ?>>Eritrea</option>
							<option value="EE" <?=set_select("country_code", "EE") ?>>Estonia</option>
							<option value="ET" <?=set_select("country_code", "ET") ?>>Ethiopia</option>
							<option value="FK" <?=set_select("country_code", "FK") ?>>Falkland Islands</option>
							<option value="FO" <?=set_select("country_code", "FO") ?>>Faroe Islands</option>
							<option value="FJ" <?=set_select("country_code", "FJ") ?>>Fiji</option>
							<option value="FI" <?=set_select("country_code", "FI") ?>>Finland</option>
							<option value="FR" <?=set_select("country_code", "FR") ?>>France</option>
							<option value="GF" <?=set_select("country_code", "GF") ?>>French Guiana</option>
							<option value="PF" <?=set_select("country_code", "PF") ?>>French Polynesia</option>
							<option value="GA" <?=set_select("country_code", "GA") ?>>Gabon</option>
							<option value="GM" <?=set_select("country_code", "GM") ?>>Gambia</option>
							<option value="GE" <?=set_select("country_code", "GE") ?>>Georgia</option>
							<option value="DE" <?=set_select("country_code", "DE") ?>>Germany</option>
							<option value="GI" <?=set_select("country_code", "GI") ?>>Gibraltar</option>
							<option value="GR" <?=set_select("country_code", "GR") ?>>Greece</option>
							<option value="GL" <?=set_select("country_code", "GL") ?>>Greenland</option>
							<option value="GD" <?=set_select("country_code", "GD") ?>>Grenada</option>
							<option value="GP" <?=set_select("country_code", "GP") ?>>Guadeloupe</option>
							<option value="GT" <?=set_select("country_code", "GT") ?>>Guatemala</option>
							<option value="GN" <?=set_select("country_code", "GN") ?>>Guinea</option>
							<option value="GW" <?=set_select("country_code", "GW") ?>>Guinea-Bissau</option>
							<option value="GY" <?=set_select("country_code", "GY") ?>>Guyana</option>
							<option value="HN" <?=set_select("country_code", "HN") ?>>Honduras</option>
							<option value="HK" <?=set_select("country_code", "HK") ?>>Hong Kong</option>
							<option value="HU" <?=set_select("country_code", "HU") ?>>Hungary</option>
							<option value="IS" <?=set_select("country_code", "IS") ?>>Iceland</option>
							<option value="IN" <?=set_select("country_code", "IN") ?>>India</option>
							<option value="ID" <?=set_select("country_code", "ID") ?>>Indonesia</option>
							<option value="IE" <?=set_select("country_code", "IE") ?>>Ireland</option>
							<option value="IL" <?=set_select("country_code", "IL") ?>>Israel</option>
							<option value="IT" <?=set_select("country_code", "IT") ?>>Italy</option>
							<option value="JM" <?=set_select("country_code", "JM") ?>>Jamaica</option>
							<option value="JP" <?=set_select("country_code", "JP") ?>>Japan</option>
							<option value="JO" <?=set_select("country_code", "JO") ?>>Jordan</option>
							<option value="KZ" <?=set_select("country_code", "KZ") ?>>Kazakhstan</option>
							<option value="KE" <?=set_select("country_code", "KE") ?>>Kenya</option>
							<option value="KI" <?=set_select("country_code", "KI") ?>>Kiribati</option>
							<option value="KW" <?=set_select("country_code", "KW") ?>>Kuwait</option>
							<option value="KG" <?=set_select("country_code", "KG") ?>>Kyrgyzstan</option>
							<option value="LA" <?=set_select("country_code", "LA") ?>>Laos</option>
							<option value="LV" <?=set_select("country_code", "LV") ?>>Latvia</option>
							<option value="LS" <?=set_select("country_code", "LS") ?>>Lesotho</option>
							<option value="LI" <?=set_select("country_code", "LI") ?>>Liechtenstein</option>
							<option value="LT" <?=set_select("country_code", "LT") ?>>Lithuania</option>
							<option value="LU" <?=set_select("country_code", "LU") ?>>Luxembourg</option>
							<option value="MK" <?=set_select("country_code", "MK") ?>>Macedonia</option>
							<option value="MG" <?=set_select("country_code", "MG") ?>>Madagascar</option>
							<option value="MW" <?=set_select("country_code", "MW") ?>>Malawi</option>
							<option value="MY" <?=set_select("country_code", "MY") ?>>Malaysia</option>
							<option value="MV" <?=set_select("country_code", "MV") ?>>Maldives</option>
							<option value="ML" <?=set_select("country_code", "ML") ?>>Mali</option>
							<option value="MT" <?=set_select("country_code", "MT") ?>>Malta</option>
							<option value="MH" <?=set_select("country_code", "MH") ?>>Marshall Islands</option>
							<option value="MQ" <?=set_select("country_code", "MQ") ?>>Martinique</option>
							<option value="MR" <?=set_select("country_code", "MR") ?>>Mauritania</option>
							<option value="MU" <?=set_select("country_code", "MU") ?>>Mauritius</option>
							<option value="YT" <?=set_select("country_code", "YT") ?>>Mayotte</option>
							<option value="MX" <?=set_select("country_code", "MX") ?>>Mexico</option>
							<option value="FM" <?=set_select("country_code", "FM") ?>>Micronesia</option>
							<option value="MD" <?=set_select("country_code", "MD") ?>>Moldova</option>
							<option value="MC" <?=set_select("country_code", "MC") ?>>Monaco</option>
							<option value="MN" <?=set_select("country_code", "MN") ?>>Mongolia</option>
							<option value="ME" <?=set_select("country_code", "ME") ?>>Montenegro</option>
							<option value="MS" <?=set_select("country_code", "MS") ?>>Montserrat</option>
							<option value="MA" <?=set_select("country_code", "MA") ?>>Morocco</option>
							<option value="MZ" <?=set_select("country_code", "MZ") ?>>Mozambique</option>
							<option value="NA" <?=set_select("country_code", "NA") ?>>Namibia</option>
							<option value="NR" <?=set_select("country_code", "NR") ?>>Nauru</option>
							<option value="NP" <?=set_select("country_code", "NP") ?>>Nepal</option>
							<option value="NL" <?=set_select("country_code", "NL") ?>>Netherlands</option>
							<option value="NC" <?=set_select("country_code", "NC") ?>>New Caledonia</option>
							<option value="NZ" <?=set_select("country_code", "NZ") ?>>New Zealand</option>
							<option value="NI" <?=set_select("country_code", "NI") ?>>Nicaragua</option>
							<option value="NE" <?=set_select("country_code", "NE") ?>>Niger</option>
							<option value="NG" <?=set_select("country_code", "NG") ?>>Nigeria</option>
							<option value="NU" <?=set_select("country_code", "NU") ?>>Niue</option>
							<option value="NF" <?=set_select("country_code", "NF") ?>>Norfolk Island</option>
							<option value="NO" <?=set_select("country_code", "NO") ?>>Norway</option>
							<option value="OM" <?=set_select("country_code", "OM") ?>>Oman</option>
							<option value="PW" <?=set_select("country_code", "PW") ?>>Palau</option>
							<option value="PA" <?=set_select("country_code", "PA") ?>>Panama</option>
							<option value="PG" <?=set_select("country_code", "PG") ?>>Papua New Guinea</option>
							<option value="PY" <?=set_select("country_code", "PY") ?>>Paraguay</option>
							<option value="PE" <?=set_select("country_code", "PE") ?>>Peru</option>
							<option value="PH" <?=set_select("country_code", "PH") ?>>Philippines</option>
							<option value="PN" <?=set_select("country_code", "PN") ?>>Pitcairn Islands</option>
							<option value="PL" <?=set_select("country_code", "PL") ?>>Poland</option>
							<option value="PT" <?=set_select("country_code", "PT") ?>>Portugal</option>
							<option value="QA" <?=set_select("country_code", "QA") ?>>Qatar</option>
							<option value="RE" <?=set_select("country_code", "RE") ?>>Reunion</option>
							<option value="RO" <?=set_select("country_code", "RO") ?>>Romania</option>
							<option value="RU" <?=set_select("country_code", "RU") ?>>Russia</option>
							<option value="RW" <?=set_select("country_code", "RW") ?>>Rwanda</option>
							<option value="WS" <?=set_select("country_code", "WS") ?>>Samoa</option>
							<option value="SM" <?=set_select("country_code", "SM") ?>>San Marino</option>
							<option value="ST" <?=set_select("country_code", "ST") ?>>Sao Tome and Principe</option>
							<option value="SA" <?=set_select("country_code", "SA") ?>>Saudi Arabia</option>
							<option value="SN" <?=set_select("country_code", "SN") ?>>Senegal</option>
							<option value="RS" <?=set_select("country_code", "RS") ?>>Serbia</option>
							<option value="SC" <?=set_select("country_code", "SC") ?>>Seychelles</option>
							<option value="SL" <?=set_select("country_code", "SL") ?>>Sierra Leone</option>
							<option value="SG" <?=set_select("country_code", "SG") ?>>Singapore</option>
							<option value="SK" <?=set_select("country_code", "SK") ?>>Slovakia</option>
							<option value="SI" <?=set_select("country_code", "SI") ?>>Slovenia</option>
							<option value="SB" <?=set_select("country_code", "SB") ?>>Solomon Islands</option>
							<option value="SO" <?=set_select("country_code", "SO") ?>>Somalia</option>
							<option value="ZA" <?=set_select("country_code", "ZA") ?>>South Africa</option>
							<option value="KR" <?=set_select("country_code", "KR") ?>>South Korea</option>
							<option value="ES" <?=set_select("country_code", "ES") ?>>Spain</option>
							<option value="LK" <?=set_select("country_code", "LK") ?>>Sri Lanka</option>
							<option value="SH" <?=set_select("country_code", "SH") ?>>St. Helena</option>
							<option value="KN" <?=set_select("country_code", "KN") ?>>St. Kitts and Nevis</option>
							<option value="LC" <?=set_select("country_code", "LC") ?>>St. Lucia</option>
							<option value="PM" <?=set_select("country_code", "PM") ?>>St. Pierre and Miquelon</option>
							<option value="VC" <?=set_select("country_code", "VC") ?>>St. Vincent and Grenadines</option>
							<option value="SR" <?=set_select("country_code", "SR") ?>>Suriname</option>
							<option value="SJ" <?=set_select("country_code", "SJ") ?>>Svalbard and Jan Mayen</option>
							<option value="SZ" <?=set_select("country_code", "SZ") ?>>Swaziland</option>
							<option value="SE" <?=set_select("country_code", "SE") ?>>Sweden</option>
							<option value="CH" <?=set_select("country_code", "CH") ?>>Switzerland</option>
							<option value="TW" <?=set_select("country_code", "TW") ?>>Taiwan</option>
							<option value="TJ" <?=set_select("country_code", "TJ") ?>>Tajikistan</option>
							<option value="TZ" <?=set_select("country_code", "TZ") ?>>Tanzania</option>
							<option value="TH" <?=set_select("country_code", "TH") ?>>Thailand</option>
							<option value="TG" <?=set_select("country_code", "TG") ?>>Togo</option>
							<option value="TO" <?=set_select("country_code", "TO") ?>>Tonga</option>
							<option value="TT" <?=set_select("country_code", "TT") ?>>Trinidad and Tobago</option>
							<option value="TN" <?=set_select("country_code", "TN") ?>>Tunisia</option>
							<option value="TM" <?=set_select("country_code", "TM") ?>>Turkmenistan</option>
							<option value="TC" <?=set_select("country_code", "TC") ?>>Turks and Caicos Islands</option>
							<option value="TV" <?=set_select("country_code", "TV") ?>>Tuvalu</option>
							<option value="UG" <?=set_select("country_code", "UG") ?>>Uganda</option>
							<option value="UA" <?=set_select("country_code", "UA") ?>>Ukraine</option>
							<option value="AE" <?=set_select("country_code", "AE") ?>>United Arab Emirates</option>
							<option value="GB" <?=set_select("country_code", "GB") ?>>United Kingdom</option>
							<option value="US" <?=set_select("country_code", "US") ?>>United States</option>
							<option value="UY" <?=set_select("country_code", "UY") ?>>Uruguay</option>
							<option value="VU" <?=set_select("country_code", "VU") ?>>Vanuatu</option>
							<option value="VA" <?=set_select("country_code", "VA") ?>>Vatican City</option>
							<option value="VE" <?=set_select("country_code", "VE") ?>>Venezuela</option>
							<option value="VN" <?=set_select("country_code", "VN") ?>>Vietnam</option>
							<option value="WF" <?=set_select("country_code", "WF") ?>>Wallis and Futuna</option>
							<option value="YE" <?=set_select("country_code", "YE") ?>>Yemen</option>
							<option value="ZM" <?=set_select("country_code", "ZM") ?>>Zambia</option>
							<option value="ZW" <?=set_select("country_code", "ZW") ?>>Zimbabwe</option>
						</select>
						<?=form_error('country_code');?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="phone" class="label label-primary">Phone</label>
						<input type="text" name="phone" id="phone" class="form-control" value="<?=set_value('phone')?>">
						<?=form_error('phone');?>
					</div>
				</div>
			</div>
		</fieldset>
		<div class="form-group">
			<input type="submit" class="btn btn-primary">
		</div>
	<?=form_close();?>
</div>

<script>
	$(function(){
		$("input").keyup(function(){
			$(this).closest('div').find('.alert').fadeOut();
		});

		$("select").change(function(){
			$(this).closest('div').find('.alert').fadeOut();
		});

		$("#date_of_birth").keydown(function(e){
			e.preventDefault();
		});

		$('#date_of_birth').datepicker({
		    format: 'mm/dd/yyyy',
		    autoclose: true
		});
		
	});
</script>