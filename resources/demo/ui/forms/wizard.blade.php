<x-theme theme="adminkit">
    <x-main-content>
        <x-container-fluid>

            <!-- start page title -->
        	<x-row >
            	<x-col class="col-8">
                	<div class="page-title-box">
                    	<ol class="breadcrumb m-0">
                        	<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        	<li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                        	<li class="breadcrumb-item active">Wizard</li>
                    	</ol>

        				<div class="mb-3">
                        	<h1 class="h3 d-inline align-middle">Wizard</h1>
                            <p></p>
                    	</div>
                	</div>
            	</x-col>
        	</x-row>
        	<!-- end page title -->

            <div class="relative">
                <div class="absolute bottom-4 right-0">
                    <div class="btn-group">
                        <a href="#" class="btn btn-secondary">메뉴얼</a>
                    </div>
                </div>
            </div>


            <div class="row mt-5">
                <div class="col-lg-6 col-xl-12 col-xxl-6 h-100">
                    <div class="d-flex mb-4">
                        <span class="fa-stack me-2 ms-n1">
                            <svg
                                class="svg-inline--fa fa-circle fa-w-16 fa-stack-2x text-300" aria-hidden="true"
                                focusable="false" data-prefix="fas" data-icon="circle" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                        </svg>
                        <!-- <i class="fas fa-circle fa-stack-2x text-300"></i> Font Awesome fontawesome.com -->
                        <svg
                                class="svg-inline--fa fa-spinner fa-w-16 fa-inverse fa-stack-1x text-primary"
                                aria-hidden="true" focusable="false" data-prefix="fas" data-icon="spinner" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
                                </path>
                            </svg>
                            <!-- <i class="fa-inverse fa-stack-1x text-primary fas fa-spinner"></i> Font Awesome fontawesome.com --></span>
                        <div class="col">
                            <h5 class="mb-0 text-primary position-relative">
                                <span
                                    class="bg-200 dark__bg-1100 pe-3">Progress tab</span>
                                <span
                                    class="border position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                            </h5>
                            <p class="mb-0">You can easily show your stats content by using these cards.</p>
                        </div>
                    </div>
                    <div class="card theme-wizard mb-5">

                        <div class="card-header bg-light pt-3 pb-2">
                            <ul class="nav justify-content-between nav-wizard">
                                <li class="nav-item">
                                    <a class="nav-link active fw-semi-bold"
                                        href="#bootstrap-wizard-tab1" data-bs-toggle="tab"
                                        data-wizard-step="data-wizard-step">
                                        <span class="nav-item-circle-parent">
                                            <span class="nav-item-circle">
                                                <svg class="svg-inline--fa fa-lock fa-w-14"
                                                    aria-hidden="true" focusable="false" data-prefix="fas"
                                                    data-icon="lock" role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 448 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fas fa-lock"></span> Font Awesome fontawesome.com -->
                                            </span>
                                        </span>

                                        <span class="d-none d-md-block mt-1 fs--1">Account</span>
                                    </a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2"
                                        data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><svg
                                                    class="svg-inline--fa fa-user fa-w-14" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="user" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fas fa-user"></span> Font Awesome fontawesome.com --></span></span><span
                                            class="d-none d-md-block mt-1 fs--1">Personal</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab3"
                                        data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><svg
                                                    class="svg-inline--fa fa-dollar-sign fa-w-9" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="dollar-sign"
                                                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 288 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fas fa-dollar-sign"></span> Font Awesome fontawesome.com --></span></span><span
                                            class="d-none d-md-block mt-1 fs--1">Billing</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab4"
                                        data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><svg
                                                    class="svg-inline--fa fa-thumbs-up fa-w-16" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="thumbs-up" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M104 224H24c-13.255 0-24 10.745-24 24v240c0 13.255 10.745 24 24 24h80c13.255 0 24-10.745 24-24V248c0-13.255-10.745-24-24-24zM64 472c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zM384 81.452c0 42.416-25.97 66.208-33.277 94.548h101.723c33.397 0 59.397 27.746 59.553 58.098.084 17.938-7.546 37.249-19.439 49.197l-.11.11c9.836 23.337 8.237 56.037-9.308 79.469 8.681 25.895-.069 57.704-16.382 74.757 4.298 17.598 2.244 32.575-6.148 44.632C440.202 511.587 389.616 512 346.839 512l-2.845-.001c-48.287-.017-87.806-17.598-119.56-31.725-15.957-7.099-36.821-15.887-52.651-16.178-6.54-.12-11.783-5.457-11.783-11.998v-213.77c0-3.2 1.282-6.271 3.558-8.521 39.614-39.144 56.648-80.587 89.117-113.111 14.804-14.832 20.188-37.236 25.393-58.902C282.515 39.293 291.817 0 312 0c24 0 72 8 72 81.452z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fas fa-thumbs-up"></span> Font Awesome fontawesome.com --></span></span><span
                                            class="d-none d-md-block mt-1 fs--1">Done</span></a></li>
                            </ul>
                        </div>
                        <div class="card-body py-4">
                            <div class="tab-content">
                                <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1">
                                    <form novalidate="novalidate">
                                        <div class="mb-3"><label class="form-label"
                                                for="bootstrap-wizard-wizard-name">Name</label><input
                                                class="form-control" type="text" name="name" placeholder="John Smith"
                                                id="bootstrap-wizard-wizard-name"></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="bootstrap-wizard-wizard-email">Email*</label><input
                                                class="form-control" type="email" name="email"
                                                placeholder="Email address"
                                                pattern="^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$"
                                                required="required" id="bootstrap-wizard-wizard-email"
                                                data-wizard-validate-email="true">
                                            <div class="invalid-feedback">You must add email</div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="bootstrap-wizard-wizard-password">Password*</label><input
                                                        class="form-control" type="password" name="password"
                                                        placeholder="Password" required="required"
                                                        id="bootstrap-wizard-wizard-password"
                                                        data-wizard-validate-password="true">
                                                    <div class="invalid-feedback">Please enter password</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="bootstrap-wizard-wizard-confirm-password">Confirm
                                                        Password*</label><input class="form-control" type="password"
                                                        name="confirmPassword" placeholder="Confirm Password"
                                                        required="required"
                                                        id="bootstrap-wizard-wizard-confirm-password"
                                                        data-wizard-validate-confirm-password="true">
                                                    <div class="invalid-feedback">Passwords need to match</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox"
                                                name="terms" required="required" checked="checked"
                                                id="bootstrap-wizard-wizard-checkbox"><label class="form-check-label"
                                                for="bootstrap-wizard-wizard-checkbox">I accept the <a href="#!">terms
                                                </a>and <a href="#!">privacy policy</a></label></div>
                                    </form>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2">
                                    <form>
                                        <div class="mb-3">
                                            <div class="row dz-clickable" data-dropzone="data-dropzone"
                                                data-options="{&quot;maxFiles&quot;:1,&quot;data&quot;:[{&quot;name&quot;:&quot;avatar.png&quot;,&quot;size&quot;:&quot;54kb&quot;,&quot;url&quot;:&quot;../../assets/img/team&quot;}]}">

                                                <div class="col-md-auto">
                                                    <div class="dz-preview dz-preview-single">
                                                        <div
                                                            class="dz-preview-cover d-flex align-items-center justify-content-center mb-3 mb-md-0 dz-image-preview">
                                                            <div class="avatar avatar-4xl"><img class="rounded-circle"
                                                                    src="../../assets/img/team/avatar.png"
                                                                    alt="avatar.png"
                                                                    data-dz-thumbnail="data-dz-thumbnail"></div>
                                                            <div class="dz-progress"><span class="dz-upload"
                                                                    data-dz-uploadprogress=""></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <div class="dz-message dropzone-area px-2 py-3"
                                                        data-dz-message="data-dz-message">
                                                        <div class="text-center"><img class="me-2"
                                                                src="../../assets/img/icons/cloud-upload.svg" width="25"
                                                                alt="">Upload your profile picture<p
                                                                class="mb-0 fs--1 text-400">Upload a 300x300 jpg image
                                                                with <br>a maximum size of 400KB</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3"><label class="form-label"
                                                for="bootstrap-wizard-gender">Gender</label><select class="form-select"
                                                name="gender" id="bootstrap-wizard-gender">
                                                <option value="">Select your gender ...</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="bootstrap-wizard-wizard-phone">Phone</label><input
                                                class="form-control" type="text" name="phone" placeholder="Phone"
                                                id="bootstrap-wizard-wizard-phone"></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="bootstrap-wizard-wizard-datepicker">Date of Birth</label><input
                                                class="form-control datetimepicker flatpickr-input" type="text"
                                                placeholder="d/m/y"
                                                data-options="{&quot;dateFormat&quot;:&quot;d/m/y&quot;,&quot;disableMobile&quot;:true}"
                                                id="bootstrap-wizard-wizard-datepicker" readonly="readonly"></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="bootstrap-wizard-wizard-address">Address</label><textarea
                                                class="form-control" rows="4"
                                                id="bootstrap-wizard-wizard-address"></textarea></div>
                                    </form>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3">
                                    <form class="form-validation">
                                        <div class="row g-2">
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label"
                                                        for="bootstrap-wizard-card-number">Card Number</label><input
                                                        class="form-control" placeholder="XXXX XXXX XXXX XXXX"
                                                        type="text" id="bootstrap-wizard-card-number"></div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label"
                                                        for="bootstrap-wizard-card-name">Name on Card</label><input
                                                        class="form-control" placeholder="John Doe" name="cardName"
                                                        type="text" id="bootstrap-wizard-card-name"></div>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="bootstrap-wizard-card-holder-country">Country</label><select
                                                        class="form-select" name="customSelectCountry"
                                                        id="bootstrap-wizard-card-holder-country">
                                                        <option value="">Select your country ...</option>
                                                        <option value="Afghanistan">Afghanistan</option>
                                                        <option value="Albania">Albania</option>
                                                        <option value="Algeria">Algeria</option>
                                                        <option value="American Samoa">American Samoa</option>
                                                        <option value="Andorra">Andorra</option>
                                                        <option value="Angola">Angola</option>
                                                        <option value="Anguilla">Anguilla</option>
                                                        <option value="Antarctica">Antarctica</option>
                                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                        <option value="Argentina">Argentina</option>
                                                        <option value="Armenia">Armenia</option>
                                                        <option value="Aruba">Aruba</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Austria">Austria</option>
                                                        <option value="Azerbaijan">Azerbaijan</option>
                                                        <option value="Bahamas">Bahamas</option>
                                                        <option value="Bahrain">Bahrain</option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                        <option value="Barbados">Barbados</option>
                                                        <option value="Belarus">Belarus</option>
                                                        <option value="Belgium">Belgium</option>
                                                        <option value="Belize">Belize</option>
                                                        <option value="Benin">Benin</option>
                                                        <option value="Bermuda">Bermuda</option>
                                                        <option value="Bhutan">Bhutan</option>
                                                        <option value="Bolivia">Bolivia</option>
                                                        <option value="Bosnia and Herzegowina">Bosnia and Herzegowina
                                                        </option>
                                                        <option value="Botswana">Botswana</option>
                                                        <option value="Bouvet Island">Bouvet Island</option>
                                                        <option value="Brazil">Brazil</option>
                                                        <option value="British Indian Ocean Territory">British Indian
                                                            Ocean Territory</option>
                                                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                        <option value="Bulgaria">Bulgaria</option>
                                                        <option value="Burkina Faso">Burkina Faso</option>
                                                        <option value="Burundi">Burundi</option>
                                                        <option value="Cambodia">Cambodia</option>
                                                        <option value="Cameroon">Cameroon</option>
                                                        <option value="Canada">Canada</option>
                                                        <option value="Cape Verde">Cape Verde</option>
                                                        <option value="Cayman Islands">Cayman Islands</option>
                                                        <option value="Central African Republic">Central African
                                                            Republic</option>
                                                        <option value="Chad">Chad</option>
                                                        <option value="Chile">Chile</option>
                                                        <option value="China">China</option>
                                                        <option value="Christmas Island">Christmas Island</option>
                                                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands
                                                        </option>
                                                        <option value="Colombia">Colombia</option>
                                                        <option value="Comoros">Comoros</option>
                                                        <option value="Congo">Congo</option>
                                                        <option value="Congo, the Democratic Republic of the">Congo, the
                                                            Democratic Republic of the</option>
                                                        <option value="Cook Islands">Cook Islands</option>
                                                        <option value="Costa Rica">Costa Rica</option>
                                                        <option value="Cote d'Ivoire">Cote d'Ivoire</option>
                                                        <option value="Croatia (Hrvatska)">Croatia (Hrvatska)</option>
                                                        <option value="Cuba">Cuba</option>
                                                        <option value="Cyprus">Cyprus</option>
                                                        <option value="Czech Republic">Czech Republic</option>
                                                        <option value="Denmark">Denmark</option>
                                                        <option value="Djibouti">Djibouti</option>
                                                        <option value="Dominica">Dominica</option>
                                                        <option value="Dominican Republic">Dominican Republic</option>
                                                        <option value="East Timor">East Timor</option>
                                                        <option value="Ecuador">Ecuador</option>
                                                        <option value="Egypt">Egypt</option>
                                                        <option value="El Salvador">El Salvador</option>
                                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                        <option value="Eritrea">Eritrea</option>
                                                        <option value="Estonia">Estonia</option>
                                                        <option value="Ethiopia">Ethiopia</option>
                                                        <option value="Falkland Islands (Malvinas)">Falkland Islands
                                                            (Malvinas)</option>
                                                        <option value="Faroe Islands">Faroe Islands</option>
                                                        <option value="Fiji">Fiji</option>
                                                        <option value="Finland">Finland</option>
                                                        <option value="France">France</option>
                                                        <option value="France Metropolitan">France Metropolitan</option>
                                                        <option value="French Guiana">French Guiana</option>
                                                        <option value="French Polynesia">French Polynesia</option>
                                                        <option value="French Southern Territories">French Southern
                                                            Territories</option>
                                                        <option value="Gabon">Gabon</option>
                                                        <option value="Gambia">Gambia</option>
                                                        <option value="Georgia">Georgia</option>
                                                        <option value="Germany">Germany</option>
                                                        <option value="Ghana">Ghana</option>
                                                        <option value="Gibraltar">Gibraltar</option>
                                                        <option value="Greece">Greece</option>
                                                        <option value="Greenland">Greenland</option>
                                                        <option value="Grenada">Grenada</option>
                                                        <option value="Guadeloupe">Guadeloupe</option>
                                                        <option value="Guam">Guam</option>
                                                        <option value="Guatemala">Guatemala</option>
                                                        <option value="Guinea">Guinea</option>
                                                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                        <option value="Guyana">Guyana</option>
                                                        <option value="Haiti">Haiti</option>
                                                        <option value="Heard and Mc Donald Islands">Heard and Mc Donald
                                                            Islands</option>
                                                        <option value="Holy See (Vatican City State)">Holy See (Vatican
                                                            City State)</option>
                                                        <option value="Honduras">Honduras</option>
                                                        <option value="Hong Kong">Hong Kong</option>
                                                        <option value="Hungary">Hungary</option>
                                                        <option value="Iceland">Iceland</option>
                                                        <option value="India">India</option>
                                                        <option value="Indonesia">Indonesia</option>
                                                        <option value="Iran (Islamic Republic of)">Iran (Islamic
                                                            Republic of)</option>
                                                        <option value="Iraq">Iraq</option>
                                                        <option value="Ireland">Ireland</option>
                                                        <option value="Israel">Israel</option>
                                                        <option value="Italy">Italy</option>
                                                        <option value="Jamaica">Jamaica</option>
                                                        <option value="Japan">Japan</option>
                                                        <option value="Jordan">Jordan</option>
                                                        <option value="Kazakhstan">Kazakhstan</option>
                                                        <option value="Kenya">Kenya</option>
                                                        <option value="Kiribati">Kiribati</option>
                                                        <option value="Korea, Democratic People's Republic of">Korea,
                                                            Democratic People's Republic of</option>
                                                        <option value="Korea, Republic of">Korea, Republic of</option>
                                                        <option value="Kuwait">Kuwait</option>
                                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                        <option value="Lao, People's Democratic Republic">Lao, People's
                                                            Democratic Republic</option>
                                                        <option value="Latvia">Latvia</option>
                                                        <option value="Lebanon">Lebanon</option>
                                                        <option value="Lesotho">Lesotho</option>
                                                        <option value="Liberia">Liberia</option>
                                                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya
                                                        </option>
                                                        <option value="Liechtenstein">Liechtenstein</option>
                                                        <option value="Lithuania">Lithuania</option>
                                                        <option value="Luxembourg">Luxembourg</option>
                                                        <option value="Macau">Macau</option>
                                                        <option value="Macedonia, The Former Yugoslav Republic of">
                                                            Macedonia, The Former Yugoslav Republic of</option>
                                                        <option value="Madagascar">Madagascar</option>
                                                        <option value="Malawi">Malawi</option>
                                                        <option value="Malaysia">Malaysia</option>
                                                        <option value="Maldives">Maldives</option>
                                                        <option value="Mali">Mali</option>
                                                        <option value="Malta">Malta</option>
                                                        <option value="Marshall Islands">Marshall Islands</option>
                                                        <option value="Martinique">Martinique</option>
                                                        <option value="Mauritania">Mauritania</option>
                                                        <option value="Mauritius">Mauritius</option>
                                                        <option value="Mayotte">Mayotte</option>
                                                        <option value="Mexico">Mexico</option>
                                                        <option value="Micronesia, Federated States of">Micronesia,
                                                            Federated States of</option>
                                                        <option value="Moldova, Republic of">Moldova, Republic of
                                                        </option>
                                                        <option value="Monaco">Monaco</option>
                                                        <option value="Mongolia">Mongolia</option>
                                                        <option value="Montserrat">Montserrat</option>
                                                        <option value="Morocco">Morocco</option>
                                                        <option value="Mozambique">Mozambique</option>
                                                        <option value="Myanmar">Myanmar</option>
                                                        <option value="Namibia">Namibia</option>
                                                        <option value="Nauru">Nauru</option>
                                                        <option value="Nepal">Nepal</option>
                                                        <option value="Netherlands">Netherlands</option>
                                                        <option value="Netherlands Antilles">Netherlands Antilles
                                                        </option>
                                                        <option value="New Caledonia">New Caledonia</option>
                                                        <option value="New Zealand">New Zealand</option>
                                                        <option value="Nicaragua">Nicaragua</option>
                                                        <option value="Niger">Niger</option>
                                                        <option value="Nigeria">Nigeria</option>
                                                        <option value="Niue">Niue</option>
                                                        <option value="Norfolk Island">Norfolk Island</option>
                                                        <option value="Northern Mariana Islands">Northern Mariana
                                                            Islands</option>
                                                        <option value="Norway">Norway</option>
                                                        <option value="Oman">Oman</option>
                                                        <option value="Pakistan">Pakistan</option>
                                                        <option value="Palau">Palau</option>
                                                        <option value="Panama">Panama</option>
                                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                                        <option value="Paraguay">Paraguay</option>
                                                        <option value="Peru">Peru</option>
                                                        <option value="Philippines">Philippines</option>
                                                        <option value="Pitcairn">Pitcairn</option>
                                                        <option value="Poland">Poland</option>
                                                        <option value="Portugal">Portugal</option>
                                                        <option value="Puerto Rico">Puerto Rico</option>
                                                        <option value="Qatar">Qatar</option>
                                                        <option value="Reunion">Reunion</option>
                                                        <option value="Romania">Romania</option>
                                                        <option value="Russian Federation">Russian Federation</option>
                                                        <option value="Rwanda">Rwanda</option>
                                                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis
                                                        </option>
                                                        <option value="Saint Lucia">Saint Lucia</option>
                                                        <option value="Saint Vincent and the Grenadines">Saint Vincent
                                                            and the Grenadines</option>
                                                        <option value="Samoa">Samoa</option>
                                                        <option value="San Marino">San Marino</option>
                                                        <option value="Sao Tome and Principe">Sao Tome and Principe
                                                        </option>
                                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                                        <option value="Senegal">Senegal</option>
                                                        <option value="Seychelles">Seychelles</option>
                                                        <option value="Sierra Leone">Sierra Leone</option>
                                                        <option value="Singapore">Singapore</option>
                                                        <option value="Slovakia (Slovak Republic)">Slovakia (Slovak
                                                            Republic)</option>
                                                        <option value="Slovenia">Slovenia</option>
                                                        <option value="Solomon Islands">Solomon Islands</option>
                                                        <option value="Somalia">Somalia</option>
                                                        <option value="South Africa">South Africa</option>
                                                        <option value="South Georgia and the South Sandwich Islands">
                                                            South Georgia and the South Sandwich Islands</option>
                                                        <option value="Spain">Spain</option>
                                                        <option value="Sri Lanka">Sri Lanka</option>
                                                        <option value="St. Helena">St. Helena</option>
                                                        <option value="St. Pierre and Miquelon">St. Pierre and Miquelon
                                                        </option>
                                                        <option value="Sudan">Sudan</option>
                                                        <option value="Suriname">Suriname</option>
                                                        <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan
                                                            Mayen Islands</option>
                                                        <option value="Swaziland">Swaziland</option>
                                                        <option value="Sweden">Sweden</option>
                                                        <option value="Switzerland">Switzerland</option>
                                                        <option value="Syrian Arab Republic">Syrian Arab Republic
                                                        </option>
                                                        <option value="Taiwan, Province of China">Taiwan, Province of
                                                            China</option>
                                                        <option value="Tajikistan">Tajikistan</option>
                                                        <option value="Tanzania, United Republic of">Tanzania, United
                                                            Republic of</option>
                                                        <option value="Thailand">Thailand</option>
                                                        <option value="Togo">Togo</option>
                                                        <option value="Tokelau">Tokelau</option>
                                                        <option value="Tonga">Tonga</option>
                                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                        <option value="Tunisia">Tunisia</option>
                                                        <option value="Turkey">Turkey</option>
                                                        <option value="Turkmenistan">Turkmenistan</option>
                                                        <option value="Turks and Caicos Islands">Turks and Caicos
                                                            Islands</option>
                                                        <option value="Tuvalu">Tuvalu</option>
                                                        <option value="Uganda">Uganda</option>
                                                        <option value="Ukraine">Ukraine</option>
                                                        <option value="United Arab Emirates">United Arab Emirates
                                                        </option>
                                                        <option value="United Kingdom">United Kingdom</option>
                                                        <option value="United States">United States</option>
                                                        <option value="United States Minor Outlying Islands">United
                                                            States Minor Outlying Islands</option>
                                                        <option value="Uruguay">Uruguay</option>
                                                        <option value="Uzbekistan">Uzbekistan</option>
                                                        <option value="Vanuatu">Vanuatu</option>
                                                        <option value="Venezuela">Venezuela</option>
                                                        <option value="Vietnam">Vietnam</option>
                                                        <option value="Virgin Islands (British)">Virgin Islands
                                                            (British)</option>
                                                        <option value="Virgin Islands (U.S.)">Virgin Islands (U.S.)
                                                        </option>
                                                        <option value="Wallis and Futuna Islands">Wallis and Futuna
                                                            Islands</option>
                                                        <option value="Western Sahara">Western Sahara</option>
                                                        <option value="Yemen">Yemen</option>
                                                        <option value="Yugoslavia">Yugoslavia</option>
                                                        <option value="Zambia">Zambia</option>
                                                        <option value="Zimbabwe">Zimbabwe</option>
                                                    </select></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="bootstrap-wizard-card-holder-zip-code">Zip
                                                        Code</label><input class="form-control" placeholder="1234"
                                                        name="zipCode" type="text"
                                                        id="bootstrap-wizard-card-holder-zip-code"></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-0"><label class="form-label"
                                                        for="bootstrap-wizard-card-exp-date">Exp Date</label><input
                                                        class="form-control" placeholder="15/2024" name="expDate"
                                                        type="text" id="bootstrap-wizard-card-exp-date"></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-0"><label class="form-label"
                                                        for="bootstrap-wizard-card-cvv">CVV</label><span class="ms-1"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                        data-bs-original-title="Card verification value"
                                                        aria-label="Card verification value"><svg
                                                            class="svg-inline--fa fa-question-circle fa-w-16"
                                                            aria-hidden="true" focusable="false" data-prefix="fa"
                                                            data-icon="question-circle" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zM262.655 90c-54.497 0-89.255 22.957-116.549 63.758-3.536 5.286-2.353 12.415 2.715 16.258l34.699 26.31c5.205 3.947 12.621 3.008 16.665-2.122 17.864-22.658 30.113-35.797 57.303-35.797 20.429 0 45.698 13.148 45.698 32.958 0 14.976-12.363 22.667-32.534 33.976C247.128 238.528 216 254.941 216 296v4c0 6.627 5.373 12 12 12h56c6.627 0 12-5.373 12-12v-1.333c0-28.462 83.186-29.647 83.186-106.667 0-58.002-60.165-102-116.531-102zM256 338c-25.365 0-46 20.635-46 46 0 25.364 20.635 46 46 46s46-20.636 46-46c0-25.365-20.635-46-46-46z">
                                                            </path>
                                                        </svg>
                                                        <!-- <span class="fa fa-question-circle"></span> Font Awesome fontawesome.com --></span><input
                                                        class="form-control" placeholder="123" name="cvv" maxlength="3"
                                                        pattern="[0-9]{3}" type="text" id="bootstrap-wizard-card-cvv">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4">
                                    <div class="wizard-lottie-wrapper">
                                        <div class="lottie wizard-lottie mx-auto my-3"
                                            data-options="{&quot;path&quot;:&quot;../../assets/img/animated-icons/celebration.json&quot;}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 464" width="264"
                                                height="464" preserveAspectRatio="xMidYMid meet"
                                                style="width: 100%; height: 100%; transform: translate3d(0px, 0px, 0px);">
                                                <defs>
                                                    <clipPath id="__lottie_element_6">
                                                        <rect width="264" height="464" x="0" y="0"></rect>
                                                    </clipPath>
                                                </defs>
                                                <g clip-path="url(#__lottie_element_6)">
                                                    <g transform="matrix(1,0,0,1,132,232)" opacity="1"
                                                        style="display: block;">
                                                        <g opacity="1" transform="matrix(1,0,0,1,0,146.99932861328125)">
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(203,240,248)"
                                                                                    fill-opacity="1"
                                                                                    d=" M-0.8989999890327454,80.08599853515625 C-0.7940000295639038,80.78700256347656 -0.7200000286102295,81.48899841308594 -0.6759999990463257,82.19000244140625 C-0.34200000762939453,87.56099700927734 -1.4980000257492065,93.02899932861328 -3.9690001010894775,97.80599975585938 C-5.301000118255615,100.37899780273438 -7.017000198364258,101.64800262451172 -10.517999649047852,102.7229995727539 C-11.420000076293945,105.37799835205078 -12.321000099182129,108.03399658203125 -13.111000061035156,109.33300018310547 C-13.656000137329102,110.42500305175781 -14.842000007629395,111.00900268554688 -15.972000122070312,110.91600036621094 C-17.53499984741211,110.55899810791016 -18.777999877929688,109.09200286865234 -18.628999710083008,107.28500366210938 C-18.628999710083008,107.28500366210938 -18.349000930786133,103.89600372314453 -18.349000930786133,103.89600372314453 C-20.174999237060547,103.97200012207031 -22.226999282836914,104.02999877929688 -24.260000228881836,103.86199951171875 C-25.840999603271484,103.73100280761719 -27.19700050354004,103.61900329589844 -28.760000228881836,103.26200103759766 C-28.760000228881836,103.26200103759766 -29.020999908447266,106.42500305175781 -29.020999908447266,106.42500305175781 C-29.170000076293945,108.23200225830078 -30.658000946044922,109.7020034790039 -32.23899841308594,109.57099914550781 C-33.36899948120117,109.47799682617188 -34.44200134277344,108.70700073242188 -34.79999923706055,107.54000091552734 C-35.36600112915039,106.12799835205078 -35.8390007019043,103.58699798583984 -36.31100082397461,101.0459976196289 C-37.946998596191406,100.31199645996094 -39.60300064086914,99.375 -40.85200119018555,98.06600189208984 C-42.0890007019043,96.76899719238281 -42.893001556396484,95.11699676513672 -43.507999420166016,93.45099639892578 C-45.91400146484375,86.9280014038086 -45.12699890136719,78.70800018310547 -41.91999816894531,72.60299682617188 C-38.14099884033203,65.40899658203125 -29.33300018310547,60.678001403808594 -20.74799919128418,61.38800048828125 C-15.503000259399414,61.821998596191406 -10.42300033569336,64.2509994506836 -6.7129998207092285,67.97000122070312 C-3.507999897003174,71.18299865722656 -1.5720000267028809,75.59100341796875 -0.8989999890327454,80.08599853515625z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.7431448101997375,-0.6691306233406067,0.6691306233406067,0.7431448101997375,-59.582176208496094,-5.867607116699219)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M-42.0629997253418,75.07499694824219 C-42.13100051879883,72.34600067138672 -43.540000915527344,62.6150016784668 -43.31999969482422,60.858001708984375 C-43.111000061035156,59.422000885009766 -42.117000579833984,58.492000579833984 -40.979000091552734,58.04999923706055 C-39.20000076293945,57.62900161743164 -37.465999603271484,58.4900016784668 -37.04499816894531,60.26900100708008 C-37.04499816894531,60.26900100708008 -33.599998474121094,71.36100006103516 -33.599998474121094,71.36100006103516">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.6427876353263855,0.7660444378852844,-0.7660444378852844,0.6427876353263855,54.23332977294922,31.31224822998047)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M-1.7050000429153442,77.16000366210938 C-0.7760000228881836,74.59300231933594 1.805999994277954,67.54199981689453 2.1540000438690186,65.80599975585938 C2.4110000133514404,64.37699890136719 1.7619999647140503,63.180999755859375 0.8230000138282776,62.4010009765625 C-0.7300000190734863,61.4379997253418 -2.6480000019073486,61.70500183105469 -3.6110000610351562,63.257999420166016 C-3.6110000610351562,63.257999420166016 -9.840999603271484,71.70099639892578 -9.840999603271484,71.70099639892578">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(1,0,0,0.7300000190734863,0,16.554397583007812)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(36,193,224)" fill-opacity="1"
                                                                            d=" M-18.285999298095703,71.75299835205078 C-18.694000244140625,71.70500183105469 -19.139999389648438,71.98400115966797 -19.187999725341797,72.39199829101562 C-19.22599983215332,72.71600341796875 -19.76300048828125,75.17500305175781 -22.716999053955078,74.87100219726562 C-25.66200065612793,74.48400115966797 -25.614999771118164,71.96800231933594 -25.57699966430664,71.64399719238281 C-25.52899932861328,71.23600006103516 -25.89900016784668,70.86199951171875 -26.30699920654297,70.81400299072266 C-26.71500015258789,70.76599884033203 -27.089000701904297,71.13600158691406 -27.136999130249023,71.54399871826172 C-27.22800064086914,73.02300262451172 -26.492000579833984,75.9219970703125 -22.899999618530273,76.34300231933594 C-22.895999908447266,76.34300231933594 -22.89299964904785,76.34400177001953 -22.888999938964844,76.34400177001953 C-22.88599967956543,76.34500122070312 -22.882999420166016,76.34600067138672 -22.878999710083008,76.34600067138672 C-19.28700065612793,76.76699829101562 -17.900999069213867,74.11499786376953 -17.64699935913086,72.65499877929688 C-17.599000930786133,72.24700164794922 -17.878000259399414,71.8010025024414 -18.285999298095703,71.75299835205078z M-16.341999053955078,65.36100006103516 C-15.125,65.50399780273438 -14.253000259399414,66.60600280761719 -14.395999908447266,67.822998046875 C-14.538999557495117,69.04000091552734 -15.642000198364258,69.91200256347656 -16.858999252319336,69.76899719238281 C-18.076000213623047,69.6259994506836 -18.94700050354004,68.52400207519531 -18.804000854492188,67.30699920654297 C-18.660999298095703,66.08999633789062 -17.55900001525879,65.21800231933594 -16.341999053955078,65.36100006103516z M-27.2810001373291,64.08000183105469 C-26.06399917602539,64.2229995727539 -25.191999435424805,65.32499694824219 -25.334999084472656,66.54199981689453 C-25.47800064086914,67.75900268554688 -26.579999923706055,68.63099670410156 -27.797000885009766,68.48799896240234 C-29.013999938964844,68.34500122070312 -29.88599967956543,67.24299621582031 -29.743000030517578,66.0260009765625 C-29.600000381469727,64.80899810791016 -28.49799919128418,63.9370002746582 -27.2810001373291,64.08000183105469z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(209,226,253)"
                                                                                    fill-opacity="1"
                                                                                    d=" M54.680999755859375,82.1780014038086 C54.84299850463867,82.86799621582031 54.97600173950195,83.56099700927734 55.07699966430664,84.25599670410156 C55.85300064086914,89.58100128173828 55.150001525878906,95.1259994506836 53.08100128173828,100.08999633789062 C51.965999603271484,102.76399993896484 50.361000061035156,104.1709976196289 46.96099853515625,105.53099822998047 C46.28099822998047,108.2509994506836 45.599998474121094,110.97100067138672 44.91999816894531,112.33100128173828 C44.46699905395508,113.46399688720703 43.33300018310547,114.1449966430664 42.20000076293945,114.1449966430664 C40.612998962402344,113.91799926757812 39.25299835205078,112.55899810791016 39.25299835205078,110.74500274658203 C39.25299835205078,110.74500274658203 39.25299835205078,107.34400177001953 39.25299835205078,107.34400177001953 C37.43899917602539,107.57099914550781 35.39899826049805,107.7979965209961 33.35900115966797,107.7979965209961 C31.77199935913086,107.7979965209961 30.41200065612793,107.7979965209961 28.825000762939453,107.57099914550781 C28.825000762939453,107.57099914550781 28.825000762939453,110.74500274658203 28.825000762939453,110.74500274658203 C28.825000762939453,112.55899810791016 27.46500015258789,114.1449966430664 25.878000259399414,114.1449966430664 C24.7450008392334,114.1449966430664 23.611000061035156,113.46399688720703 23.158000946044922,112.33100128173828 C22.47800064086914,110.97100067138672 21.797000885009766,108.47799682617188 21.117000579833984,105.98400115966797 C19.426000595092773,105.38700103759766 17.698999404907227,104.58999633789062 16.34600067138672,103.38800048828125 C15.005999565124512,102.1969985961914 14.069000244140625,100.61799621582031 13.319000244140625,99.00800323486328 C10.383999824523926,92.70500183105469 10.489999771118164,84.447998046875 13.182999610900879,78.0999984741211 C16.35700035095215,70.61900329589844 24.7450008392334,65.17900085449219 33.35900115966797,65.17900085449219 C38.62200164794922,65.17900085449219 43.88399887084961,67.18099975585938 47.88800048828125,70.58200073242188 C51.34700012207031,73.5199966430664 53.63999938964844,77.75399780273438 54.680999755859375,82.1780014038086z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9170722961425781,-0.39872100949287415,0.39872100949287415,0.9170722961425781,-30.94009780883789,12.980323791503906)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M11.956000328063965,83.19000244140625 C11.663999557495117,80.47599792480469 9.456000328063965,70.89399719238281 9.531000137329102,69.125 C9.621000289916992,67.6760025024414 10.53499984741211,66.66899871826172 11.631999969482422,66.13400268554688 C13.369999885559082,65.56800079345703 15.170000076293945,66.28399658203125 15.736000061035156,68.02200317382812 C15.736000061035156,68.02200317382812 20.083999633789062,78.79199981689453 20.083999633789062,78.79199981689453">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9117171764373779,0.4108183681964874,-0.4108183681964874,0.9117171764373779,37.36994171142578,-13.224647521972656)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M54.70100021362305,82.08300018310547 C55.41600036621094,79.447998046875 57.40700149536133,72.20899963378906 57.611000061035156,70.44999694824219 C57.749000549316406,69.00499725341797 57.005001068115234,67.86599731445312 56.005001068115234,67.16600036621094 C54.37699890136719,66.33399963378906 52.48699951171875,66.75800323486328 51.654998779296875,68.38600158691406 C51.654998779296875,68.38600158691406 46.141998291015625,77.31300354003906 46.141998291015625,77.31300354003906">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                            d=" M29.184999465942383,74.53700256347656 C28.781999588012695,74.51599884033203 28.437999725341797,74.9020004272461 28.41699981689453,75.30500030517578 C28.42099952697754,76.76100158691406 29.323999404907227,79.55799865722656 32.87200164794922,79.74500274658203 C36.41999816894531,79.93199920654297 37.612998962402344,77.24600219726562 37.77000045776367,75.79900360107422 C37.85100173950195,75.3219985961914 37.6510009765625,74.98400115966797 37.24800109863281,74.96299743652344 C37.24800109863281,74.96299743652344 29.184999465942383,74.53700256347656 29.184999465942383,74.53700256347656z M38.86899948120117,69.66600036621094 C40.090999603271484,69.76300048828125 41.00299835205078,70.83100128173828 40.90599822998047,72.0530014038086 C40.808998107910156,73.2750015258789 39.74100112915039,74.18699645996094 38.51900100708008,74.08999633789062 C37.297000885009766,73.99299621582031 36.3849983215332,72.92500305175781 36.481998443603516,71.7030029296875 C36.57899856567383,70.48100280761719 37.64699935913086,69.56900024414062 38.86899948120117,69.66600036621094z M27.889999389648438,68.7959976196289 C29.11199951171875,68.89299774169922 30.02400016784668,69.96099853515625 29.927000045776367,71.18299865722656 C29.829999923706055,72.40499877929688 28.761999130249023,73.31700134277344 27.540000915527344,73.22000122070312 C26.31800079345703,73.12300109863281 25.4060001373291,72.05500030517578 25.503000259399414,70.83300018310547 C25.600000381469727,69.61100006103516 26.667999267578125,68.6989974975586 27.889999389648438,68.7959976196289z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(209,226,253)"
                                                                                    fill-opacity="1"
                                                                                    d=" M-55.22200012207031,79.56400299072266 C-55.09600067138672,80.26100158691406 -55,80.96199798583984 -54.93600082397461,81.66100311279297 C-54.44200134277344,87.01899719238281 -55.435001373291016,92.51899719238281 -57.76300048828125,97.36699676513672 C-59.018001556396484,99.97899627685547 -60.69499969482422,101.29900360107422 -64.16200256347656,102.47799682617188 C-64.98400115966797,105.15899658203125 -65.80699920654297,107.83999633789062 -66.55799865722656,109.16200256347656 C-67.06999969482422,110.2699966430664 -68.23799896240234,110.88899993896484 -69.37000274658203,110.8290023803711 C-70.94300079345703,110.51899719238281 -72.2300033569336,109.08899688720703 -72.13400268554688,107.27799987792969 C-72.13400268554688,107.27799987792969 -71.95500183105469,103.88300323486328 -71.95500183105469,103.88300323486328 C-73.77799987792969,104.01399993896484 -75.8270034790039,104.13300323486328 -77.86399841308594,104.0250015258789 C-79.4489974975586,103.94100189208984 -80.80699920654297,103.87000274658203 -82.37999725341797,103.55999755859375 C-82.37999725341797,103.55999755859375 -82.5469970703125,106.72899627685547 -82.5469970703125,106.72899627685547 C-82.64299774169922,108.54000091552734 -84.08399963378906,110.0530014038086 -85.66899871826172,109.96900177001953 C-86.8010025024414,109.90899658203125 -87.89700317382812,109.1709976196289 -88.29000091552734,108.01499938964844 C-88.89700317382812,106.62100219726562 -89.44499969482422,104.09500122070312 -89.99299621582031,101.56900024414062 C-91.6500015258789,100.88400268554688 -93.33399963378906,99.99800109863281 -94.62100219726562,98.72599792480469 C-95.89600372314453,97.46600341796875 -96.75,95.83899688720703 -97.41400146484375,94.19200134277344 C-100.01300048828125,87.74299621582031 -99.47100067138672,79.50299835205078 -96.4469985961914,73.30599975585938 C-92.88300323486328,66.00299835205078 -84.22100067138672,61.01100158691406 -75.61900329589844,61.46500015258789 C-70.36299896240234,61.742000579833984 -65.21399688720703,64.0199966430664 -61.39400100708008,67.62699890136719 C-58.09400177001953,70.74299621582031 -56.02899932861328,75.09100341796875 -55.22200012207031,79.56400299072266z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.7524827122688293,-0.6586120128631592,0.6586120128631592,0.7524827122688293,-73.07736206054688,-43.64155578613281)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M-97.94100189208984,78.3239974975586 C-98.08999633789062,75.5979995727539 -99.79000091552734,65.91400146484375 -99.62200164794922,64.1510009765625 C-99.45600128173828,62.70899963378906 -98.48899841308594,61.750999450683594 -97.36499786376953,61.275001525878906 C-95.5999984741211,60.801998138427734 -93.83999633789062,61.611000061035156 -93.36699676513672,63.375999450683594 C-93.36699676513672,63.375999450683594 -89.59200286865234,74.36000061035156 -89.59200286865234,74.36000061035156">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.7524827122688293,0.6586120128631592,-0.6586120128631592,0.7524827122688293,35.74507522583008,59.25690460205078)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M-55.196998596191406,79.47100067138672 C-54.345001220703125,76.87799835205078 -51.9739990234375,69.75299835205078 -51.678001403808594,68.00700378417969 C-51.4640007019043,66.57099914550781 -52.14699935913086,65.3949966430664 -53.10900115966797,64.64299774169922 C-54.689998626708984,63.72700119018555 -56.60100173950195,64.0510025024414 -57.516998291015625,65.63200378417969 C-57.516998291015625,65.63200378417969 -63.492000579833984,74.25599670410156 -63.492000579833984,74.25599670410156">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(1,0,0,0.75,0,15.995750427246094)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                            d=" M-80.1050033569336,63.73099899291992 C-81.23400115966797,63.55500030517578 -82.35199737548828,64.11599731445312 -82.88700103759766,65.1259994506836 C-82.9990005493164,65.33799743652344 -83.0009994506836,65.58499908447266 -82.89199829101562,65.802001953125 C-82.78199768066406,66.02200317382812 -82.57099914550781,66.17500305175781 -82.3290023803711,66.21299743652344 C-82.01499938964844,66.26200103759766 -81.70099639892578,66.1050033569336 -81.5469970703125,65.82099914550781 C-81.31099700927734,65.38600158691406 -80.82499694824219,65.1449966430664 -80.33699798583984,65.22100067138672 C-79.8489990234375,65.2969970703125 -79.45999908447266,65.67400360107422 -79.36799621582031,66.16000366210938 C-79.30699920654297,66.47699737548828 -79.05599975585938,66.7229995727539 -78.74199676513672,66.77200317382812 C-78.5,66.80999755859375 -78.25199890136719,66.72699737548828 -78.08100128173828,66.5510025024414 C-77.91100311279297,66.37699890136719 -77.83799743652344,66.14099884033203 -77.87999725341797,65.90499877929688 C-78.08200073242188,64.77999877929688 -78.97599792480469,63.90700149536133 -80.1050033569336,63.73099899291992z M-66.40899658203125,67.69200134277344 C-66.61100006103516,66.56700134277344 -67.50499725341797,65.69300079345703 -68.63400268554688,65.51699829101562 C-69.76300048828125,65.34100341796875 -70.87999725341797,65.9020004272461 -71.41500091552734,66.91200256347656 C-71.5270004272461,67.1240005493164 -71.52899932861328,67.37100219726562 -71.41999816894531,67.58799743652344 C-71.30999755859375,67.80799865722656 -71.0999984741211,67.96099853515625 -70.85800170898438,67.9990005493164 C-70.54399871826172,68.0479965209961 -70.2300033569336,67.89099884033203 -70.07599639892578,67.60700225830078 C-69.83999633789062,67.1719970703125 -69.35399627685547,66.93099975585938 -68.86599731445312,67.00700378417969 C-68.37799835205078,67.08300018310547 -67.98799896240234,67.45999908447266 -67.89600372314453,67.94599914550781 C-67.83499908447266,68.26300048828125 -67.58499908447266,68.50900268554688 -67.27100372314453,68.55799865722656 C-67.02899932861328,68.59600067138672 -66.78099822998047,68.51300048828125 -66.60900115966797,68.33699798583984 C-66.43900299072266,68.16300201416016 -66.36699676513672,67.9280014038086 -66.40899658203125,67.69200134277344z M-71.51799774169922,70.24299621582031 C-71.8489990234375,70.19200134277344 -72.15399932861328,70.41600036621094 -72.27200317382812,70.73600006103516 C-72.28199768066406,70.802001953125 -72.76399993896484,73.02899932861328 -75.2770004272461,72.63800048828125 C-77.7239990234375,72.25700378417969 -77.60299682617188,70.177001953125 -77.56199645996094,69.91200256347656 C-77.51100158691406,69.58100128173828 -77.80000305175781,69.26499938964844 -78.13099670410156,69.21399688720703 C-78.46199798583984,69.16300201416016 -78.77799987792969,69.45099639892578 -78.8290023803711,69.78199768066406 C-78.947998046875,70.98300170898438 -78.43900299072266,73.36499786376953 -75.52899932861328,73.81800079345703 C-72.61900329589844,74.27100372314453 -71.40899658203125,72.15699768066406 -71.15799713134766,70.97699737548828 C-70.9739990234375,70.66699981689453 -71.18699645996094,70.29399871826172 -71.51799774169922,70.24299621582031z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(203,240,248)"
                                                                                    fill-opacity="1"
                                                                                    d=" M106.04000091552734,74.5270004272461 C106.322998046875,75.1760025024414 106.5790023803711,75.83599853515625 106.8030014038086,76.5009994506836 C108.52200317382812,81.5999984741211 108.82599639892578,87.18099975585938 107.68199920654297,92.43599700927734 C107.06500244140625,95.26699829101562 105.73799896240234,96.93900299072266 102.63700103759766,98.88700103759766 C102.45600128173828,101.68499755859375 102.2760009765625,104.48300170898438 101.85099792480469,105.94300079345703 C101.60800170898438,107.13899993896484 100.61499786376953,108.01300048828125 99.5,108.21600341796875 C97.89800262451172,108.27799987792969 96.31700134277344,107.18399810791016 95.99099731445312,105.4000015258789 C95.99099731445312,105.4000015258789 95.37999725341797,102.05400085449219 95.37999725341797,102.05400085449219 C93.63700103759766,102.60299682617188 91.66999816894531,103.19200134277344 89.66300201416016,103.55799865722656 C88.10199737548828,103.84300231933594 86.76399993896484,104.08699798583984 85.16200256347656,104.14900207519531 C85.16200256347656,104.14900207519531 85.73200225830078,107.27100372314453 85.73200225830078,107.27100372314453 C86.05799865722656,109.05500030517578 85.00399780273438,110.86100006103516 83.44300079345703,111.14600372314453 C82.3280029296875,111.3489990234375 81.09100341796875,110.88400268554688 80.44200134277344,109.8499984741211 C79.52899932861328,108.63400268554688 78.41200256347656,106.3030014038086 77.29499816894531,103.97200012207031 C75.52400207519531,103.68800354003906 73.68099975585938,103.21499633789062 72.13500213623047,102.2750015258789 C70.60299682617188,101.34400177001953 69.39800262451172,99.95800018310547 68.37100219726562,98.50900268554688 C64.35199737548828,92.83599853515625 62.9739990234375,84.69300079345703 64.48400115966797,77.96499633789062 C66.26300048828125,70.03600311279297 73.53800201416016,63.178001403808594 82.01300048828125,61.63199996948242 C87.19100189208984,60.6870002746582 92.72599792480469,61.71200180053711 97.2760009765625,64.33899688720703 C101.20600128173828,66.60800170898438 104.22100067138672,70.36199951171875 106.04000091552734,74.5270004272461z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.7174413800239563,-0.6966188549995422,0.6966188549995422,0.7174413800239563,-35.48551940917969,69.2641372680664)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M64.19000244140625,83.19300079345703 C63.415000915527344,80.57499694824219 59.52399826049805,71.5459976196289 59.279998779296875,69.79199981689453 C59.10900115966797,68.35099792480469 59.82699966430664,67.19499969482422 60.81100082397461,66.47200012207031 C62.41899871826172,65.60299682617188 64.31800079345703,65.98400115966797 65.18699645996094,67.59200286865234 C65.18699645996094,67.59200286865234 71.39700317382812,77.40699768066406 71.39700317382812,77.40699768066406">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.8599865436553955,0.5103167295455933,-0.5103167295455933,0.8599865436553955,50.897918701171875,-41.2591552734375)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M106.04299926757812,74.43099975585938 C106.27300262451172,71.71099853515625 106.93199920654297,64.23100280761719 106.81700134277344,62.4640007019043 C106.69400024414062,61.018001556396484 105.75599670410156,60.03200149536133 104.64700317382812,59.52199935913086 C102.89700317382812,58.99599838256836 101.11399841308594,59.75199890136719 100.58799743652344,61.50199890136719 C100.58799743652344,61.50199890136719 96.76699829101562,71.27400207519531 96.76699829101562,71.27400207519531">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(36,193,224)" fill-opacity="1"
                                                                            d=" M85.03199768066406,68.8239974975586 C84.63999938964844,68.9469985961914 84.34600067138672,69.38400268554688 84.46900177001953,69.7760009765625 C84.56600189208984,70.08699798583984 85.08000183105469,72.5510025024414 82.25900268554688,73.47899627685547 C79.41300201416016,74.3270034790039 78.4280014038086,72.01000213623047 78.33100128173828,71.6989974975586 C78.20800018310547,71.30699920654297 77.71800231933594,71.11599731445312 77.32599639892578,71.23899841308594 C76.93399810791016,71.36199951171875 76.74299621582031,71.85199737548828 76.86599731445312,72.24400329589844 C77.38700103759766,73.63099670410156 79.24099731445312,75.97799682617188 82.69200134277344,74.89700317382812 C82.69599914550781,74.89600372314453 82.6989974975586,74.89399719238281 82.7020034790039,74.89299774169922 C82.70500183105469,74.89199829101562 82.70899963378906,74.89199829101562 82.71299743652344,74.89099884033203 C86.16400146484375,73.80999755859375 86.3479995727539,70.822998046875 85.98400115966797,69.38700103759766 C85.86100006103516,68.99500274658203 85.42400360107422,68.70099639892578 85.03199768066406,68.8239974975586z M84.61499786376953,63.027000427246094 C85.78399658203125,62.6609992980957 87.02999877929688,63.3120002746582 87.39600372314453,64.48100280761719 C87.76200103759766,65.6500015258789 87.11100006103516,66.89600372314453 85.94200134277344,67.26200103759766 C84.77300262451172,67.62799835205078 83.5270004272461,66.97699737548828 83.16100311279297,65.80799865722656 C82.79499816894531,64.63899993896484 83.44599914550781,63.393001556396484 84.61499786376953,63.027000427246094z M74.1050033569336,66.31999969482422 C75.27400207519531,65.9540023803711 76.52100372314453,66.6050033569336 76.88700103759766,67.77400207519531 C77.25299835205078,68.94300079345703 76.60099792480469,70.18900299072266 75.43199920654297,70.55500030517578 C74.26300048828125,70.9209976196289 73.01699829101562,70.2699966430664 72.6510009765625,69.10099792480469 C72.28500366210938,67.93199920654297 72.93599700927734,66.68599700927734 74.1050033569336,66.31999969482422z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g opacity="1"
                                                            transform="matrix(0.9820472002029419,0.1886354684829712,-0.1886354684829712,0.9820472002029419,2.958207130432129,139.64097595214844)">
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(209,226,253)" fill-opacity="1"
                                                                            d=" M22.850000381469727,28.0939998626709 C22.364999771118164,28.86400032043457 21.849000930786133,29.608999252319336 21.30500030517578,30.327999114990234 C17.132999420166016,35.83599853515625 11.428000450134277,40.191001892089844 5.021999835968018,42.770999908447266 C1.5700000524520874,44.1609992980957 -1.1629999876022339,43.95899963378906 -5.4710001945495605,42.07400131225586 C-8.572999954223633,43.90299987792969 -11.673999786376953,45.731998443603516 -13.531000137329102,46.334999084472656 C-14.97599983215332,46.94200134277344 -16.621000289916992,46.518001556396484 -17.642000198364258,45.48099899291992 C-18.864999771118164,43.82500076293945 -18.844999313354492,41.35499954223633 -17.18600082397461,39.72100067138672 C-17.18600082397461,39.72100067138672 -14.076000213623047,36.65700149536133 -14.076000213623047,36.65700149536133 C-15.918000221252441,35.20199966430664 -17.964000701904297,33.540000915527344 -19.802000045776367,31.67300033569336 C-21.23200035095215,30.22100067138672 -22.457000732421875,28.976999282836914 -23.68000030517578,27.320999145507812 C-23.68000030517578,27.320999145507812 -26.58300018310547,30.180999755859375 -26.58300018310547,30.180999755859375 C-28.242000579833984,31.815000534057617 -30.920000076293945,32.000999450683594 -32.349998474121094,30.548999786376953 C-33.37099838256836,29.511999130249023 -33.77000045776367,27.86199951171875 -33.141998291015625,26.426000595092773 C-32.5099983215332,24.577999114990234 -30.840999603271484,21.708999633789062 -29.17300033569336,18.84000015258789 C-30.150999069213867,16.7549991607666 -30.979000091552734,14.456999778747559 -31.097999572753906,12.13599967956543 C-31.215999603271484,9.836999893188477 -30.615999221801758,7.556000232696533 -29.819000244140625,5.419000148773193 C-26.697999954223633,-2.946000099182129 -19.04800033569336,-10.288999557495117 -10.814000129699707,-13.545000076293945 C-1.1100000143051147,-17.382999420166016 11.425999641418457,-14.612000465393066 19.187999725341797,-6.730999946594238 C23.93000030517578,-1.9160000085830688 26.84000015258789,4.702000141143799 27.336999893188477,11.430000305175781 C27.766000747680664,17.242000579833984 25.958999633789062,23.155000686645508 22.850000381469727,28.0939998626709z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(0.8861058354377747,-0.46348291635513306,0.46348291635513306,0.8861058354377747,-3.660140037536621,-6.477550029754639)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(209,226,253)" fill-opacity="1"
                                                                            d=" M-7.302999973297119,-6.633999824523926 C-7.302999973297119,-6.633999824523926 -7.98199987411499,-21.533000946044922 -7.98199987411499,-21.533000946044922 C-7.927000045776367,-23.878999710083008 -9.803000450134277,-25.511999130249023 -12.14900016784668,-25.566999435424805 C-13.706000328063965,-25.386999130249023 -15.243000030517578,-24.55699920654297 -15.968999862670898,-22.84000015258789 C-16.812999725341797,-20.729000091552734 -18.22100067138672,-8.180000305175781 -19.023000717163086,-4.76800012588501 C-19.023000717163086,-4.76800012588501 -7.302999973297119,-6.633999824523926 -7.302999973297119,-6.633999824523926z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(0.9433565139770508,0.3317808210849762,-0.3317808210849762,0.9433565139770508,8.91514778137207,-6.267143249511719)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(209,226,253)" fill-opacity="1"
                                                                            d=" M22.694000244140625,16.281999588012695 C22.694000244140625,16.281999588012695 19.381999969482422,28.62700080871582 19.381999969482422,28.62700080871582 C22.832000732421875,29.24799919128418 32.314998626708984,30.990999221801758 34.5880012512207,31.055999755859375 C36.45199966430664,31.07200050354004 37.82500076293945,29.993000030517578 38.61000061035156,28.63599967956543 C39.49300003051758,26.461000442504883 38.742000579833984,24.090999603271484 36.56700134277344,23.20800018310547 C36.56700134277344,23.20800018310547 22.694000244140625,16.281999588012695 22.694000244140625,16.281999588012695">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                        d=" M-1.2269999980926514,-1.253999948501587 C-1.4980000257492065,-1.5800000429153442 -2.0429999828338623,-1.5700000524520874 -2.36899995803833,-1.2990000247955322 C-3.490000009536743,-0.25699999928474426 -5.004000186920166,2.437000036239624 -2.615999937057495,5.309999942779541 C-0.2280000001192093,8.182999610900879 2.697000026702881,7.188000202178955 3.927000045776367,6.276000022888184 C4.353000164031982,5.999000072479248 4.4710001945495605,5.6020002365112305 4.199999809265137,5.276000022888184 C4.199999809265137,5.276000022888184 -1.2269999980926514,-1.253999948501587 -1.2269999980926514,-1.253999948501587z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(25,118,210)" fill-opacity="1"
                                                                        d=" M-3.5950000286102295,0.5690000057220459 C-4.074999809265137,1.8559999465942383 -4.079999923706055,3.5480000972747803 -2.615999937057495,5.309999942779541 C-1.7510000467300415,6.349999904632568 -0.8180000185966492,6.879000186920166 0.0820000022649765,7.0920000076293945 C0.17299999296665192,6.692999839782715 0.22599999606609344,6.28000020980835 0.22599999606609344,5.853000164031982 C0.22599999606609344,3.3889999389648438 -1.3769999742507935,1.3020000457763672 -3.5950000286102295,0.5690000057220459z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(225,247,249)" fill-opacity="1"
                                                                        d=" M23.834999084472656,10.664999961853027 C23.23699951171875,10.83899974822998 22.854999542236328,11.383000373840332 22.93000030517578,12.010000228881836 C23.347999572753906,15.670000076293945 20.679000854492188,17.636999130249023 20.679000854492188,17.636999130249023 C20.040000915527344,18.038999557495117 19.944000244140625,18.823999404907227 20.34600067138672,19.46299934387207 C20.74799919128418,20.101999282836914 21.533000946044922,20.19700050354004 22.172000885009766,19.795000076293945 C22.341999053955078,19.636999130249023 26.09000015258789,16.923999786376953 25.565000534057617,11.781999588012695 C25.461000442504883,11.055999755859375 24.888999938964844,10.574000358581543 24.163000106811523,10.678000450134277 C24.034000396728516,10.607000350952148 23.934999465942383,10.63599967956543 23.834999084472656,10.664999961853027z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(255,167,38)" fill-opacity="1"
                                                                        d=" M19.1560001373291,9.093999862670898 C15.958999633789062,12.027999877929688 10.989999771118164,11.8149995803833 8.055999755859375,8.618000030517578 C5.122000217437744,5.421000003814697 5.335000038146973,0.4519999921321869 8.531999588012695,-2.4820001125335693 C11.729000091552734,-5.415999889373779 16.697999954223633,-5.203000068664551 19.631999969482422,-2.00600004196167 C22.56599998474121,1.190999984741211 22.35300064086914,6.159999847412109 19.1560001373291,9.093999862670898z M6.388999938964844,-4.816999912261963 C3.191999912261963,-1.8830000162124634 -1.7769999504089355,-2.0969998836517334 -4.710999965667725,-5.294000148773193 C-7.644999980926514,-8.491000175476074 -7.432000160217285,-13.460000038146973 -4.235000133514404,-16.393999099731445 C-1.0379999876022339,-19.327999114990234 3.930999994277954,-19.11400032043457 6.864999771118164,-15.916999816894531 C9.798999786376953,-12.720000267028809 9.586000442504883,-7.750999927520752 6.388999938964844,-4.816999912261963z M9.54699993133545,-0.1979999989271164 C9.54699993133545,-0.1979999989271164 4.315999984741211,-5.896999835968018 4.315999984741211,-5.896999835968018 C4.315999984741211,-5.896999835968018 6.343999862670898,-7.757999897003174 6.343999862670898,-7.757999897003174 C6.343999862670898,-7.757999897003174 11.574999809265137,-2.059000015258789 11.574999809265137,-2.059000015258789 C11.574999809265137,-2.059000015258789 9.54699993133545,-0.1979999989271164 9.54699993133545,-0.1979999989271164z M23.389999389648438,3.885999917984009 C23.389999389648438,4.690999984741211 22.73699951171875,5.343999862670898 21.93199920654297,5.343999862670898 C21.12700080871582,5.343999862670898 20.474000930786133,4.690999984741211 20.474000930786133,3.885999917984009 C20.474000930786133,3.0810000896453857 21.12700080871582,2.427999973297119 21.93199920654297,2.427999973297119 C22.73699951171875,2.427999973297119 23.389999389648438,3.0810000896453857 23.389999389648438,3.885999917984009z M2.13100004196167,-18.613000869750977 C2.13100004196167,-17.808000564575195 1.4780000448226929,-17.15399932861328 0.6729999780654907,-17.15399932861328 C-0.13199999928474426,-17.15399932861328 -0.7860000133514404,-17.808000564575195 -0.7860000133514404,-18.613000869750977 C-0.7860000133514404,-19.417999267578125 -0.13199999928474426,-20.070999145507812 0.6729999780654907,-20.070999145507812 C1.4780000448226929,-20.070999145507812 2.13100004196167,-19.417999267578125 2.13100004196167,-18.613000869750977z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                        d=" M17.871000289916992,7.693999767303467 C15.446999549865723,9.918000221252441 11.680000305175781,9.756999969482422 9.456000328063965,7.333000183105469 C7.23199987411499,4.908999919891357 7.392000198364258,1.1410000324249268 9.815999984741211,-1.0829999446868896 C12.239999771118164,-3.306999921798706 16.007999420166016,-3.1459999084472656 18.23200035095215,-0.722000002861023 C20.45599937438965,1.7020000219345093 20.295000076293945,5.46999979019165 17.871000289916992,7.693999767303467z M5.104000091552734,-6.2170000076293945 C2.680000066757202,-3.993000030517578 -1.0870000123977661,-4.1539998054504395 -3.311000108718872,-6.578000068664551 C-5.534999847412109,-9.001999855041504 -5.374000072479248,-12.770000457763672 -2.950000047683716,-14.994000434875488 C-0.5260000228881836,-17.218000411987305 3.240999937057495,-17.05699920654297 5.465000152587891,-14.633000373840332 C7.689000129699707,-12.208999633789062 7.5279998779296875,-8.440999984741211 5.104000091552734,-6.2170000076293945z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="0.3" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(255,255,255)" fill-opacity="1"
                                                                        d=" M-4.666999816894531,-9.097999572753906 C-4.427999973297119,-8.194000244140625 -4,-7.328000068664551 -3.3239998817443848,-6.591000080108643 C-2.74399995803833,-5.959000110626221 -2.053999900817871,-5.488999843597412 -1.315000057220459,-5.166999816894531 C-1.315000057220459,-5.166999816894531 6.163000106811523,-7.5920000076293945 6.163000106811523,-7.5920000076293945 C7.125999927520752,-9.21500015258789 7.263000011444092,-11.190999984741211 6.534999847412109,-12.920999526977539 C6.534999847412109,-12.920999526977539 -4.666999816894531,-9.097999572753906 -4.666999816894531,-9.097999572753906z M8.112000465393066,4.826000213623047 C8.35099983215332,5.730000019073486 8.779999732971191,6.5960001945495605 9.456000328063965,7.333000183105469 C10.03600025177002,7.965000152587891 10.725000381469727,8.435999870300293 11.46399974822998,8.758000373840332 C11.46399974822998,8.758000373840332 18.941999435424805,6.333000183105469 18.941999435424805,6.333000183105469 C19.905000686645508,4.710000038146973 20.04199981689453,2.7339999675750732 19.31399917602539,1.003999948501587 C19.31399917602539,1.003999948501587 8.112000465393066,4.826000213623047 8.112000465393066,4.826000213623047z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                            <g opacity="1"
                                                                transform="matrix(0.2193390130996704,0.9756487011909485,-0.9756487011909485,0.2193390130996704,55.24310302734375,-52.9581298828125)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(203,240,248)" fill-opacity="1"
                                                                            d=" M46.28300094604492,-9.434000015258789 C46.28300094604492,-9.434000015258789 29.57900047302246,-8.812999725341797 29.57900047302246,-8.812999725341797 C29.1560001373291,-8.79699993133545 28.878000259399414,-8.366999626159668 29.03700065612793,-7.974999904632568 C29.03700065612793,-7.974999904632568 30.96500015258789,-3.2279999256134033 30.96500015258789,-3.2279999256134033 C30.96500015258789,-3.2279999256134033 31.507999420166016,-1.8919999599456787 31.507999420166016,-1.8919999599456787 C31.507999420166016,-1.8919999599456787 33.43600082397461,2.8519999980926514 33.43600082397461,2.8519999980926514 C33.59600067138672,3.244999885559082 34.095001220703125,3.359999895095825 34.409000396728516,3.075000047683716 C36.5880012512207,1.093999981880188 43.7140007019043,-5.385000228881836 46.79399871826172,-8.190999984741211 C47.2869987487793,-8.640999794006348 46.95000076293945,-9.458999633789062 46.28300094604492,-9.434000015258789z">
                                                                        </path>
                                                                    </g>
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(148,219,224)" fill-opacity="1"
                                                                            d=" M30.836999893188477,-3.5429999828338623 C30.836999893188477,-3.5429999828338623 38.24700164794922,-0.41499999165534973 38.24700164794922,-0.41499999165534973 C39.04600143432617,-1.1410000324249268 39.895999908447266,-1.9140000343322754 40.75199890136719,-2.693000078201294 C40.75199890136719,-2.693000078201294 29.20199966430664,-7.570000171661377 29.20199966430664,-7.570000171661377 C29.20199966430664,-7.570000171661377 30.836999893188477,-3.5429999828338623 30.836999893188477,-3.5429999828338623z">
                                                                        </path>
                                                                    </g>
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(148,219,224)" fill-opacity="1"
                                                                            d=" M34.09600067138672,-8.980999946594238 C34.09600067138672,-8.980999946594238 43.36399841308594,-5.067999839782715 43.36399841308594,-5.067999839782715 C44.27899932861328,-5.901000022888184 45.13399887084961,-6.678999900817871 45.86800003051758,-7.3470001220703125 C45.86800003051758,-7.3470001220703125 41.356998443603516,-9.25100040435791 41.356998443603516,-9.25100040435791 C41.356998443603516,-9.25100040435791 34.09600067138672,-8.980999946594238 34.09600067138672,-8.980999946594238z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(148,219,224)" fill-opacity="1"
                                                                        d=" M50.084999084472656,-9.02400016784668 C49.917999267578125,-7.9670000076293945 48.92499923706055,-7.245999813079834 47.86800003051758,-7.413000106811523 C46.81100082397461,-7.579999923706055 46.09000015258789,-8.572999954223633 46.25699996948242,-9.630000114440918 C46.42399978637695,-10.687000274658203 47.41699981689453,-11.407999992370605 48.4739990234375,-11.241000175476074 C49.53099822998047,-11.074000358581543 50.25199890136719,-10.081000328063965 50.084999084472656,-9.02400016784668z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g opacity="1" transform="matrix(1,0,0,1,0,147)">
                                                            <g opacity="0" transform="matrix(1,0,0,1,-25,24)">
                                                                <path fill="rgb(246,102,56)" fill-opacity="1"
                                                                    d=" M62.60100173950195,18.645999908447266 C60.78099822998047,23.586000442504883 56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 C56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 C56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 C56.1879997253418,24.972999572753906 60.867000579833984,26.358999252319336 62.513999938964844,31.298999786376953 C64.33399963378906,26.358999252319336 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.927001953125,24.972999572753906 64.24800109863281,23.586000442504883 62.60100173950195,18.645999908447266">
                                                                </path>
                                                            </g>
                                                            <g opacity="0"
                                                                transform="matrix(0.5150380730628967,0.8571673035621643,-0.8571673035621643,0.5150380730628967,12.08004379272461,76.05459594726562)">
                                                                <path fill="rgb(253,202,64)" fill-opacity="1"
                                                                    d=" M-61.39899826049805,42.3129997253418 C-63.21900177001953,47.25299835205078 -67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 C-67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 C-67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 C-67.81199645996094,48.638999938964844 -63.132999420166016,50.0260009765625 -61.486000061035156,54.965999603271484 C-59.66600036621094,50.0260009765625 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.073001861572266,48.638999938964844 -59.75199890136719,47.25299835205078 -61.39899826049805,42.3129997253418">
                                                                </path>
                                                            </g>
                                                            <g opacity="0" transform="matrix(1,0,0,1,0,0)">
                                                                <path fill="rgb(253,202,64)" fill-opacity="1"
                                                                    d=" M29.243999481201172,-37.02000045776367 C27.90399932861328,-33.38199996948242 24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 C24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 C24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 C24.520999908447266,-32.36000061035156 27.966999053955078,-31.339000701904297 29.18000030517578,-27.701000213623047 C30.520000457763672,-31.339000701904297 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.90399932861328,-32.36000061035156 30.457000732421875,-33.38199996948242 29.243999481201172,-37.02000045776367">
                                                                </path>
                                                            </g>
                                                            <g opacity="0" transform="matrix(1,0,0,1,0,0)">
                                                                <path fill="rgb(246,102,56)" fill-opacity="1"
                                                                    d=" M-54.15999984741211,-6.0269999504089355 C-55.42100143432617,-2.6040000915527344 -58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 C-58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 C-58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 C-58.604000091552734,-1.6430000066757202 -55.361000061035156,-0.6819999814033508 -54.220001220703125,2.740999937057495 C-52.95899963378906,-0.6819999814033508 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.775001525878906,-1.6430000066757202 -53.01900100708008,-2.6040000915527344 -54.15999984741211,-6.0269999504089355">
                                                                </path>
                                                            </g>
                                                            <g opacity="0"
                                                                transform="matrix(0.9131986498832703,-0.793831467628479,0.793831467628479,0.9131986498832703,-8.248411178588867,0.6842203140258789)">
                                                                <path fill="rgb(255,255,255)" fill-opacity="1"
                                                                    d=" M-42.262001037597656,-30.163000106811523 C-41.54399871826172,-29.516000747680664 -41.487998962402344,-28.409000396728516 -42.1349983215332,-27.69099998474121 C-42.78200149536133,-26.972999572753906 -43.88800048828125,-26.91699981689453 -44.60599899291992,-27.56399917602539 M47.02899932861328,50.5369987487793 C48.38600158691406,49.99800109863281 49.92499923706055,50.6609992980957 50.4640007019043,52.018001556396484 C51.00299835205078,53.375 50.34000015258789,54.91299819946289 48.983001708984375,55.45199966430664">
                                                                </path>
                                                                <path fill="rgb(255,213,79)" fill-opacity="1"
                                                                    d=" M47.02899932861328,50.5369987487793 C48.38600158691406,49.99800109863281 49.92499923706055,50.6609992980957 50.4640007019043,52.018001556396484 C51.00299835205078,53.375 50.34000015258789,54.91299819946289 48.983001708984375,55.45199966430664">
                                                                </path>
                                                            </g>
                                                            <g opacity="0"
                                                                transform="matrix(0.9612616896629333,0.27563735842704773,-0.27563735842704773,0.9612616896629333,0,0)">
                                                                <path fill="rgb(255,213,79)" fill-opacity="1"
                                                                    d=" M73.93099975585938,-6.883999824523926 C74.88200378417969,-6.291999816894531 75.1719970703125,-5.040999889373779 74.58000183105469,-4.090000152587891 C73.98799896240234,-3.1389999389648438 72.73699951171875,-2.8480000495910645 71.78600311279297,-3.440000057220459">
                                                                </path>
                                                            </g>
                                                            <g opacity="0" transform="matrix(1,0,0,1,0,-11)">
                                                                <path fill="rgb(255,213,79)" fill-opacity="1"
                                                                    d=" M69.44400024414062,41.17900085449219 C69.44400024414062,42.18000030517578 68.63200378417969,42.992000579833984 67.63099670410156,42.992000579833984 C66.62999725341797,42.992000579833984 65.81800079345703,42.18000030517578 65.81800079345703,41.17900085449219 C65.81800079345703,40.178001403808594 66.62999725341797,39.36600112915039 67.63099670410156,39.36600112915039 C68.63200378417969,39.36600112915039 69.44400024414062,40.178001403808594 69.44400024414062,41.17900085449219z">
                                                                </path>
                                                            </g>
                                                            <g opacity="0" transform="matrix(1,0,0,1,-14,-38)">
                                                                <path fill="rgb(245,245,245)" fill-opacity="1"
                                                                    d=" M-53.305999755859375,27.448999404907227 C-53.305999755859375,28.450000762939453 -54.11800003051758,29.261999130249023 -55.11899948120117,29.261999130249023 C-56.119998931884766,29.261999130249023 -56.93199920654297,28.450000762939453 -56.93199920654297,27.448999404907227 C-56.93199920654297,26.447999954223633 -56.119998931884766,25.63599967956543 -55.11899948120117,25.63599967956543 C-54.11800003051758,25.63599967956543 -53.305999755859375,26.447999954223633 -53.305999755859375,27.448999404907227z">
                                                                </path>
                                                            </g>
                                                            <g opacity="0"
                                                                transform="matrix(0.9063078165054321,-0.4226182699203491,0.4226182699203491,0.9063078165054321,-1.9754083156585693,0.057509422302246094)">
                                                                <path fill="rgb(52,168,83)" fill-opacity="1"
                                                                    d=" M-53.867000579833984,-20.260000228881836 C-53.867000579833984,-19.259000778198242 -54.67900085449219,-18.445999145507812 -55.68000030517578,-18.445999145507812 C-56.680999755859375,-18.445999145507812 -57.49300003051758,-19.259000778198242 -57.49300003051758,-20.260000228881836 C-57.49300003051758,-21.26099967956543 -56.680999755859375,-22.072999954223633 -55.68000030517578,-22.072999954223633 C-54.67900085449219,-22.072999954223633 -53.867000579833984,-21.26099967956543 -53.867000579833984,-20.260000228881836z M53.694000244140625,-25.40399932861328 C53.694000244140625,-24.402999877929688 52.88199996948242,-23.590999603271484 51.88100051879883,-23.590999603271484 C50.880001068115234,-23.590999603271484 50.06800079345703,-24.402999877929688 50.06800079345703,-25.40399932861328 C50.06800079345703,-26.405000686645508 50.880001068115234,-27.216999053955078 51.88100051879883,-27.216999053955078 C52.88199996948242,-27.216999053955078 53.694000244140625,-26.405000686645508 53.694000244140625,-25.40399932861328z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg></div>
                                    </div>
                                    <h4 class="mb-1">Your account is all set!</h4>
                                    <p>Now you can access to your account</p><a class="btn btn-primary px-5 my-3"
                                        href="../../modules/forms/wizard.html">Start Over</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="px-sm-3 px-md-5">
                                <ul class="pager wizard list-inline mb-0">
                                    <li class="previous"><button class="btn btn-link ps-0 d-none" type="button"><svg
                                                class="svg-inline--fa fa-chevron-left fa-w-10 me-2"
                                                data-fa-transform="shrink-3" aria-hidden="true" focusable="false"
                                                data-prefix="fas" data-icon="chevron-left" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;">
                                                <g transform="translate(160 256)">
                                                    <g
                                                        transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                        <path fill="currentColor"
                                                            d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"
                                                            transform="translate(-160 -256)"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <!-- <span class="fas fa-chevron-left me-2" data-fa-transform="shrink-3"></span> Font Awesome fontawesome.com -->Prev</button>
                                    </li>
                                    <li class="next"><button class="btn btn-primary px-5 px-sm-6" type="submit">Next<svg
                                                class="svg-inline--fa fa-chevron-right fa-w-10 ms-2"
                                                data-fa-transform="shrink-3" aria-hidden="true" focusable="false"
                                                data-prefix="fas" data-icon="chevron-right" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;">
                                                <g transform="translate(160 256)">
                                                    <g
                                                        transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                        <path fill="currentColor"
                                                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"
                                                            transform="translate(-160 -256)"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <!-- <span class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3"> </span> Font Awesome fontawesome.com --></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-12 col-xxl-6 h-100">
                    <div class="d-flex mb-4"><span class="fa-stack me-2 ms-n1"><svg
                                class="svg-inline--fa fa-circle fa-w-16 fa-stack-2x text-300" aria-hidden="true"
                                focusable="false" data-prefix="fas" data-icon="circle" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                            </svg>
                            <!-- <i class="fas fa-circle fa-stack-2x text-300"></i> Font Awesome fontawesome.com --><svg
                                class="svg-inline--fa fa-check-double fa-w-16 fa-inverse fa-stack-1x text-primary"
                                aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-double"
                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M505 174.8l-39.6-39.6c-9.4-9.4-24.6-9.4-33.9 0L192 374.7 80.6 263.2c-9.4-9.4-24.6-9.4-33.9 0L7 302.9c-9.4 9.4-9.4 24.6 0 34L175 505c9.4 9.4 24.6 9.4 33.9 0l296-296.2c9.4-9.5 9.4-24.7.1-34zm-324.3 106c6.2 6.3 16.4 6.3 22.6 0l208-208.2c6.2-6.3 6.2-16.4 0-22.6L366.1 4.7c-6.2-6.3-16.4-6.3-22.6 0L192 156.2l-55.4-55.5c-6.2-6.3-16.4-6.3-22.6 0L68.7 146c-6.2 6.3-6.2 16.4 0 22.6l112 112.2z">
                                </path>
                            </svg>
                            <!-- <i class="fa-inverse fa-stack-1x text-primary fas fa-check-double"></i> Font Awesome fontawesome.com --></span>
                        <div class="col">
                            <h5 class="mb-0 text-primary position-relative"><span class="bg-200 dark__bg-1100 pe-3">With
                                    Validation</span><span
                                    class="border position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                            </h5>
                            <p class="mb-0">You can easily show your stats content by using these cards.</p>
                        </div>
                    </div>
                    <div class="card theme-wizard h-100">
                        <div class="card-header bg-light pt-3 pb-2">
                            <ul class="nav justify-content-between nav-wizard">
                                <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                        href="#bootstrap-wizard-validation-tab1" data-bs-toggle="tab"
                                        data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span
                                                class="nav-item-circle"><svg class="svg-inline--fa fa-lock fa-w-14"
                                                    aria-hidden="true" focusable="false" data-prefix="fas"
                                                    data-icon="lock" role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 448 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fas fa-lock"></span> Font Awesome fontawesome.com --></span></span><span
                                            class="d-none d-md-block mt-1 fs--1">Account</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold"
                                        href="#bootstrap-wizard-validation-tab2" data-bs-toggle="tab"
                                        data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span
                                                class="nav-item-circle"><svg class="svg-inline--fa fa-user fa-w-14"
                                                    aria-hidden="true" focusable="false" data-prefix="fas"
                                                    data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 448 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fas fa-user"></span> Font Awesome fontawesome.com --></span></span><span
                                            class="d-none d-md-block mt-1 fs--1">Personal</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold"
                                        href="#bootstrap-wizard-validation-tab3" data-bs-toggle="tab"
                                        data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span
                                                class="nav-item-circle"><svg
                                                    class="svg-inline--fa fa-dollar-sign fa-w-9" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="dollar-sign"
                                                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 288 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fas fa-dollar-sign"></span> Font Awesome fontawesome.com --></span></span><span
                                            class="d-none d-md-block mt-1 fs--1">Billing</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold"
                                        href="#bootstrap-wizard-validation-tab4" data-bs-toggle="tab"
                                        data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span
                                                class="nav-item-circle"><svg class="svg-inline--fa fa-thumbs-up fa-w-16"
                                                    aria-hidden="true" focusable="false" data-prefix="fas"
                                                    data-icon="thumbs-up" role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M104 224H24c-13.255 0-24 10.745-24 24v240c0 13.255 10.745 24 24 24h80c13.255 0 24-10.745 24-24V248c0-13.255-10.745-24-24-24zM64 472c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zM384 81.452c0 42.416-25.97 66.208-33.277 94.548h101.723c33.397 0 59.397 27.746 59.553 58.098.084 17.938-7.546 37.249-19.439 49.197l-.11.11c9.836 23.337 8.237 56.037-9.308 79.469 8.681 25.895-.069 57.704-16.382 74.757 4.298 17.598 2.244 32.575-6.148 44.632C440.202 511.587 389.616 512 346.839 512l-2.845-.001c-48.287-.017-87.806-17.598-119.56-31.725-15.957-7.099-36.821-15.887-52.651-16.178-6.54-.12-11.783-5.457-11.783-11.998v-213.77c0-3.2 1.282-6.271 3.558-8.521 39.614-39.144 56.648-80.587 89.117-113.111 14.804-14.832 20.188-37.236 25.393-58.902C282.515 39.293 291.817 0 312 0c24 0 72 8 72 81.452z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fas fa-thumbs-up"></span> Font Awesome fontawesome.com --></span></span><span
                                            class="d-none d-md-block mt-1 fs--1">Done</span></a></li>
                            </ul>
                        </div>
                        <div class="card-body py-4" id="wizard-controller">
                            <div class="tab-content">
                                <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-validation-tab1"
                                    id="bootstrap-wizard-validation-tab1">
                                    <form class="needs-validation" novalidate="novalidate">
                                        <div class="mb-3"><label class="form-label"
                                                for="bootstrap-wizard-validation-wizard-name">Name</label><input
                                                class="form-control" type="text" name="name" placeholder="John Smith"
                                                id="bootstrap-wizard-validation-wizard-name"></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="bootstrap-wizard-validation-wizard-email">Email*</label><input
                                                class="form-control" type="email" name="email"
                                                placeholder="Email address"
                                                pattern="^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$"
                                                required="required" id="bootstrap-wizard-validation-wizard-email"
                                                data-wizard-validate-email="true">
                                            <div class="invalid-feedback">You must add email</div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="bootstrap-wizard-validation-wizard-password">Password*</label><input
                                                        class="form-control" type="password" name="password"
                                                        placeholder="Password" required="required"
                                                        id="bootstrap-wizard-validation-wizard-password"
                                                        data-wizard-validate-password="true">
                                                    <div class="invalid-feedback">Please enter password</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="bootstrap-wizard-validation-wizard-confirm-password">Confirm
                                                        Password*</label><input class="form-control" type="password"
                                                        name="confirmPassword" placeholder="Confirm Password"
                                                        required="required"
                                                        id="bootstrap-wizard-validation-wizard-confirm-password"
                                                        data-wizard-validate-confirm-password="true">
                                                    <div class="invalid-feedback">Passwords need to match</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox"
                                                name="terms" required="required" checked="checked"
                                                id="bootstrap-wizard-validation-wizard-checkbox"><label
                                                class="form-check-label"
                                                for="bootstrap-wizard-validation-wizard-checkbox">I accept the <a
                                                    href="#!">terms </a>and <a href="#!">privacy policy</a></label>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-validation-tab2"
                                    id="bootstrap-wizard-validation-tab2">
                                    <form>
                                        <div class="mb-3">
                                            <div class="row dz-clickable" data-dropzone="data-dropzone"
                                                data-options="{&quot;maxFiles&quot;:1,&quot;data&quot;:[{&quot;name&quot;:&quot;avatar.png&quot;,&quot;size&quot;:&quot;54kb&quot;,&quot;url&quot;:&quot;../../assets/img/team&quot;}]}">

                                                <div class="col-md-auto">
                                                    <div class="dz-preview dz-preview-single">
                                                        <div
                                                            class="dz-preview-cover d-flex align-items-center justify-content-center mb-3 mb-md-0 dz-image-preview">
                                                            <div class="avatar avatar-4xl"><img class="rounded-circle"
                                                                    src="../../assets/img/team/avatar.png"
                                                                    alt="avatar.png"
                                                                    data-dz-thumbnail="data-dz-thumbnail"></div>
                                                            <div class="dz-progress"><span class="dz-upload"
                                                                    data-dz-uploadprogress=""></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <div class="dz-message dropzone-area px-2 py-3"
                                                        data-dz-message="data-dz-message">
                                                        <div class="text-center"><img class="me-2"
                                                                src="../../assets/img/icons/cloud-upload.svg" width="25"
                                                                alt="">Upload your profile picture<p
                                                                class="mb-0 fs--1 text-400">Upload a 300x300 jpg image
                                                                with <br>a maximum size of 400KB</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3"><label class="form-label"
                                                for="bootstrap-wizard-validation-gender">Gender</label><select
                                                class="form-select" name="gender"
                                                id="bootstrap-wizard-validation-gender">
                                                <option value="">Select your gender ...</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="bootstrap-wizard-validation-wizard-phone">Phone</label><input
                                                class="form-control" type="text" name="phone" placeholder="Phone"
                                                id="bootstrap-wizard-validation-wizard-phone"></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="bootstrap-wizard-validation-wizard-datepicker">Date of
                                                Birth</label><input class="form-control datetimepicker flatpickr-input"
                                                type="text" placeholder="d/m/y"
                                                data-options="{&quot;dateFormat&quot;:&quot;d/m/y&quot;,&quot;disableMobile&quot;:true}"
                                                id="bootstrap-wizard-validation-wizard-datepicker" readonly="readonly">
                                        </div>
                                        <div class="mb-3"><label class="form-label"
                                                for="bootstrap-wizard-validation-wizard-address">Address</label><textarea
                                                class="form-control" rows="4"
                                                id="bootstrap-wizard-validation-wizard-address"></textarea></div>
                                    </form>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-validation-tab3"
                                    id="bootstrap-wizard-validation-tab3">
                                    <form class="form-validation">
                                        <div class="row g-2">
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label"
                                                        for="bootstrap-wizard-validation-card-number">Card
                                                        Number</label><input class="form-control"
                                                        placeholder="XXXX XXXX XXXX XXXX" type="text"
                                                        id="bootstrap-wizard-validation-card-number"></div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label"
                                                        for="bootstrap-wizard-validation-card-name">Name on
                                                        Card</label><input class="form-control" placeholder="John Doe"
                                                        name="cardName" type="text"
                                                        id="bootstrap-wizard-validation-card-name"></div>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="bootstrap-wizard-validation-card-holder-country">Country</label><select
                                                        class="form-select" name="customSelectCountry"
                                                        id="bootstrap-wizard-validation-card-holder-country">
                                                        <option value="">Select your country ...</option>
                                                        <option value="Afghanistan">Afghanistan</option>
                                                        <option value="Albania">Albania</option>
                                                        <option value="Algeria">Algeria</option>
                                                        <option value="American Samoa">American Samoa</option>
                                                        <option value="Andorra">Andorra</option>
                                                        <option value="Angola">Angola</option>
                                                        <option value="Anguilla">Anguilla</option>
                                                        <option value="Antarctica">Antarctica</option>
                                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                        <option value="Argentina">Argentina</option>
                                                        <option value="Armenia">Armenia</option>
                                                        <option value="Aruba">Aruba</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Austria">Austria</option>
                                                        <option value="Azerbaijan">Azerbaijan</option>
                                                        <option value="Bahamas">Bahamas</option>
                                                        <option value="Bahrain">Bahrain</option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                        <option value="Barbados">Barbados</option>
                                                        <option value="Belarus">Belarus</option>
                                                        <option value="Belgium">Belgium</option>
                                                        <option value="Belize">Belize</option>
                                                        <option value="Benin">Benin</option>
                                                        <option value="Bermuda">Bermuda</option>
                                                        <option value="Bhutan">Bhutan</option>
                                                        <option value="Bolivia">Bolivia</option>
                                                        <option value="Bosnia and Herzegowina">Bosnia and Herzegowina
                                                        </option>
                                                        <option value="Botswana">Botswana</option>
                                                        <option value="Bouvet Island">Bouvet Island</option>
                                                        <option value="Brazil">Brazil</option>
                                                        <option value="British Indian Ocean Territory">British Indian
                                                            Ocean Territory</option>
                                                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                        <option value="Bulgaria">Bulgaria</option>
                                                        <option value="Burkina Faso">Burkina Faso</option>
                                                        <option value="Burundi">Burundi</option>
                                                        <option value="Cambodia">Cambodia</option>
                                                        <option value="Cameroon">Cameroon</option>
                                                        <option value="Canada">Canada</option>
                                                        <option value="Cape Verde">Cape Verde</option>
                                                        <option value="Cayman Islands">Cayman Islands</option>
                                                        <option value="Central African Republic">Central African
                                                            Republic</option>
                                                        <option value="Chad">Chad</option>
                                                        <option value="Chile">Chile</option>
                                                        <option value="China">China</option>
                                                        <option value="Christmas Island">Christmas Island</option>
                                                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands
                                                        </option>
                                                        <option value="Colombia">Colombia</option>
                                                        <option value="Comoros">Comoros</option>
                                                        <option value="Congo">Congo</option>
                                                        <option value="Congo, the Democratic Republic of the">Congo, the
                                                            Democratic Republic of the</option>
                                                        <option value="Cook Islands">Cook Islands</option>
                                                        <option value="Costa Rica">Costa Rica</option>
                                                        <option value="Cote d'Ivoire">Cote d'Ivoire</option>
                                                        <option value="Croatia (Hrvatska)">Croatia (Hrvatska)</option>
                                                        <option value="Cuba">Cuba</option>
                                                        <option value="Cyprus">Cyprus</option>
                                                        <option value="Czech Republic">Czech Republic</option>
                                                        <option value="Denmark">Denmark</option>
                                                        <option value="Djibouti">Djibouti</option>
                                                        <option value="Dominica">Dominica</option>
                                                        <option value="Dominican Republic">Dominican Republic</option>
                                                        <option value="East Timor">East Timor</option>
                                                        <option value="Ecuador">Ecuador</option>
                                                        <option value="Egypt">Egypt</option>
                                                        <option value="El Salvador">El Salvador</option>
                                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                        <option value="Eritrea">Eritrea</option>
                                                        <option value="Estonia">Estonia</option>
                                                        <option value="Ethiopia">Ethiopia</option>
                                                        <option value="Falkland Islands (Malvinas)">Falkland Islands
                                                            (Malvinas)</option>
                                                        <option value="Faroe Islands">Faroe Islands</option>
                                                        <option value="Fiji">Fiji</option>
                                                        <option value="Finland">Finland</option>
                                                        <option value="France">France</option>
                                                        <option value="France Metropolitan">France Metropolitan</option>
                                                        <option value="French Guiana">French Guiana</option>
                                                        <option value="French Polynesia">French Polynesia</option>
                                                        <option value="French Southern Territories">French Southern
                                                            Territories</option>
                                                        <option value="Gabon">Gabon</option>
                                                        <option value="Gambia">Gambia</option>
                                                        <option value="Georgia">Georgia</option>
                                                        <option value="Germany">Germany</option>
                                                        <option value="Ghana">Ghana</option>
                                                        <option value="Gibraltar">Gibraltar</option>
                                                        <option value="Greece">Greece</option>
                                                        <option value="Greenland">Greenland</option>
                                                        <option value="Grenada">Grenada</option>
                                                        <option value="Guadeloupe">Guadeloupe</option>
                                                        <option value="Guam">Guam</option>
                                                        <option value="Guatemala">Guatemala</option>
                                                        <option value="Guinea">Guinea</option>
                                                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                        <option value="Guyana">Guyana</option>
                                                        <option value="Haiti">Haiti</option>
                                                        <option value="Heard and Mc Donald Islands">Heard and Mc Donald
                                                            Islands</option>
                                                        <option value="Holy See (Vatican City State)">Holy See (Vatican
                                                            City State)</option>
                                                        <option value="Honduras">Honduras</option>
                                                        <option value="Hong Kong">Hong Kong</option>
                                                        <option value="Hungary">Hungary</option>
                                                        <option value="Iceland">Iceland</option>
                                                        <option value="India">India</option>
                                                        <option value="Indonesia">Indonesia</option>
                                                        <option value="Iran (Islamic Republic of)">Iran (Islamic
                                                            Republic of)</option>
                                                        <option value="Iraq">Iraq</option>
                                                        <option value="Ireland">Ireland</option>
                                                        <option value="Israel">Israel</option>
                                                        <option value="Italy">Italy</option>
                                                        <option value="Jamaica">Jamaica</option>
                                                        <option value="Japan">Japan</option>
                                                        <option value="Jordan">Jordan</option>
                                                        <option value="Kazakhstan">Kazakhstan</option>
                                                        <option value="Kenya">Kenya</option>
                                                        <option value="Kiribati">Kiribati</option>
                                                        <option value="Korea, Democratic People's Republic of">Korea,
                                                            Democratic People's Republic of</option>
                                                        <option value="Korea, Republic of">Korea, Republic of</option>
                                                        <option value="Kuwait">Kuwait</option>
                                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                        <option value="Lao, People's Democratic Republic">Lao, People's
                                                            Democratic Republic</option>
                                                        <option value="Latvia">Latvia</option>
                                                        <option value="Lebanon">Lebanon</option>
                                                        <option value="Lesotho">Lesotho</option>
                                                        <option value="Liberia">Liberia</option>
                                                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya
                                                        </option>
                                                        <option value="Liechtenstein">Liechtenstein</option>
                                                        <option value="Lithuania">Lithuania</option>
                                                        <option value="Luxembourg">Luxembourg</option>
                                                        <option value="Macau">Macau</option>
                                                        <option value="Macedonia, The Former Yugoslav Republic of">
                                                            Macedonia, The Former Yugoslav Republic of</option>
                                                        <option value="Madagascar">Madagascar</option>
                                                        <option value="Malawi">Malawi</option>
                                                        <option value="Malaysia">Malaysia</option>
                                                        <option value="Maldives">Maldives</option>
                                                        <option value="Mali">Mali</option>
                                                        <option value="Malta">Malta</option>
                                                        <option value="Marshall Islands">Marshall Islands</option>
                                                        <option value="Martinique">Martinique</option>
                                                        <option value="Mauritania">Mauritania</option>
                                                        <option value="Mauritius">Mauritius</option>
                                                        <option value="Mayotte">Mayotte</option>
                                                        <option value="Mexico">Mexico</option>
                                                        <option value="Micronesia, Federated States of">Micronesia,
                                                            Federated States of</option>
                                                        <option value="Moldova, Republic of">Moldova, Republic of
                                                        </option>
                                                        <option value="Monaco">Monaco</option>
                                                        <option value="Mongolia">Mongolia</option>
                                                        <option value="Montserrat">Montserrat</option>
                                                        <option value="Morocco">Morocco</option>
                                                        <option value="Mozambique">Mozambique</option>
                                                        <option value="Myanmar">Myanmar</option>
                                                        <option value="Namibia">Namibia</option>
                                                        <option value="Nauru">Nauru</option>
                                                        <option value="Nepal">Nepal</option>
                                                        <option value="Netherlands">Netherlands</option>
                                                        <option value="Netherlands Antilles">Netherlands Antilles
                                                        </option>
                                                        <option value="New Caledonia">New Caledonia</option>
                                                        <option value="New Zealand">New Zealand</option>
                                                        <option value="Nicaragua">Nicaragua</option>
                                                        <option value="Niger">Niger</option>
                                                        <option value="Nigeria">Nigeria</option>
                                                        <option value="Niue">Niue</option>
                                                        <option value="Norfolk Island">Norfolk Island</option>
                                                        <option value="Northern Mariana Islands">Northern Mariana
                                                            Islands</option>
                                                        <option value="Norway">Norway</option>
                                                        <option value="Oman">Oman</option>
                                                        <option value="Pakistan">Pakistan</option>
                                                        <option value="Palau">Palau</option>
                                                        <option value="Panama">Panama</option>
                                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                                        <option value="Paraguay">Paraguay</option>
                                                        <option value="Peru">Peru</option>
                                                        <option value="Philippines">Philippines</option>
                                                        <option value="Pitcairn">Pitcairn</option>
                                                        <option value="Poland">Poland</option>
                                                        <option value="Portugal">Portugal</option>
                                                        <option value="Puerto Rico">Puerto Rico</option>
                                                        <option value="Qatar">Qatar</option>
                                                        <option value="Reunion">Reunion</option>
                                                        <option value="Romania">Romania</option>
                                                        <option value="Russian Federation">Russian Federation</option>
                                                        <option value="Rwanda">Rwanda</option>
                                                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis
                                                        </option>
                                                        <option value="Saint Lucia">Saint Lucia</option>
                                                        <option value="Saint Vincent and the Grenadines">Saint Vincent
                                                            and the Grenadines</option>
                                                        <option value="Samoa">Samoa</option>
                                                        <option value="San Marino">San Marino</option>
                                                        <option value="Sao Tome and Principe">Sao Tome and Principe
                                                        </option>
                                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                                        <option value="Senegal">Senegal</option>
                                                        <option value="Seychelles">Seychelles</option>
                                                        <option value="Sierra Leone">Sierra Leone</option>
                                                        <option value="Singapore">Singapore</option>
                                                        <option value="Slovakia (Slovak Republic)">Slovakia (Slovak
                                                            Republic)</option>
                                                        <option value="Slovenia">Slovenia</option>
                                                        <option value="Solomon Islands">Solomon Islands</option>
                                                        <option value="Somalia">Somalia</option>
                                                        <option value="South Africa">South Africa</option>
                                                        <option value="South Georgia and the South Sandwich Islands">
                                                            South Georgia and the South Sandwich Islands</option>
                                                        <option value="Spain">Spain</option>
                                                        <option value="Sri Lanka">Sri Lanka</option>
                                                        <option value="St. Helena">St. Helena</option>
                                                        <option value="St. Pierre and Miquelon">St. Pierre and Miquelon
                                                        </option>
                                                        <option value="Sudan">Sudan</option>
                                                        <option value="Suriname">Suriname</option>
                                                        <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan
                                                            Mayen Islands</option>
                                                        <option value="Swaziland">Swaziland</option>
                                                        <option value="Sweden">Sweden</option>
                                                        <option value="Switzerland">Switzerland</option>
                                                        <option value="Syrian Arab Republic">Syrian Arab Republic
                                                        </option>
                                                        <option value="Taiwan, Province of China">Taiwan, Province of
                                                            China</option>
                                                        <option value="Tajikistan">Tajikistan</option>
                                                        <option value="Tanzania, United Republic of">Tanzania, United
                                                            Republic of</option>
                                                        <option value="Thailand">Thailand</option>
                                                        <option value="Togo">Togo</option>
                                                        <option value="Tokelau">Tokelau</option>
                                                        <option value="Tonga">Tonga</option>
                                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                        <option value="Tunisia">Tunisia</option>
                                                        <option value="Turkey">Turkey</option>
                                                        <option value="Turkmenistan">Turkmenistan</option>
                                                        <option value="Turks and Caicos Islands">Turks and Caicos
                                                            Islands</option>
                                                        <option value="Tuvalu">Tuvalu</option>
                                                        <option value="Uganda">Uganda</option>
                                                        <option value="Ukraine">Ukraine</option>
                                                        <option value="United Arab Emirates">United Arab Emirates
                                                        </option>
                                                        <option value="United Kingdom">United Kingdom</option>
                                                        <option value="United States">United States</option>
                                                        <option value="United States Minor Outlying Islands">United
                                                            States Minor Outlying Islands</option>
                                                        <option value="Uruguay">Uruguay</option>
                                                        <option value="Uzbekistan">Uzbekistan</option>
                                                        <option value="Vanuatu">Vanuatu</option>
                                                        <option value="Venezuela">Venezuela</option>
                                                        <option value="Vietnam">Vietnam</option>
                                                        <option value="Virgin Islands (British)">Virgin Islands
                                                            (British)</option>
                                                        <option value="Virgin Islands (U.S.)">Virgin Islands (U.S.)
                                                        </option>
                                                        <option value="Wallis and Futuna Islands">Wallis and Futuna
                                                            Islands</option>
                                                        <option value="Western Sahara">Western Sahara</option>
                                                        <option value="Yemen">Yemen</option>
                                                        <option value="Yugoslavia">Yugoslavia</option>
                                                        <option value="Zambia">Zambia</option>
                                                        <option value="Zimbabwe">Zimbabwe</option>
                                                    </select></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="bootstrap-wizard-validation-card-holder-zip-code">Zip
                                                        Code</label><input class="form-control" placeholder="1234"
                                                        name="zipCode" type="text"
                                                        id="bootstrap-wizard-validation-card-holder-zip-code"></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-0"><label class="form-label"
                                                        for="bootstrap-wizard-validation-card-exp-date">Exp
                                                        Date</label><input class="form-control" placeholder="15/2024"
                                                        name="expDate" type="text"
                                                        id="bootstrap-wizard-validation-card-exp-date"></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-0"><label class="form-label"
                                                        for="bootstrap-wizard-validation-card-cvv">CVV</label><span
                                                        class="ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="" data-bs-original-title="Card verification value"
                                                        aria-label="Card verification value"><svg
                                                            class="svg-inline--fa fa-question-circle fa-w-16"
                                                            aria-hidden="true" focusable="false" data-prefix="fa"
                                                            data-icon="question-circle" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zM262.655 90c-54.497 0-89.255 22.957-116.549 63.758-3.536 5.286-2.353 12.415 2.715 16.258l34.699 26.31c5.205 3.947 12.621 3.008 16.665-2.122 17.864-22.658 30.113-35.797 57.303-35.797 20.429 0 45.698 13.148 45.698 32.958 0 14.976-12.363 22.667-32.534 33.976C247.128 238.528 216 254.941 216 296v4c0 6.627 5.373 12 12 12h56c6.627 0 12-5.373 12-12v-1.333c0-28.462 83.186-29.647 83.186-106.667 0-58.002-60.165-102-116.531-102zM256 338c-25.365 0-46 20.635-46 46 0 25.364 20.635 46 46 46s46-20.636 46-46c0-25.365-20.635-46-46-46z">
                                                            </path>
                                                        </svg>
                                                        <!-- <span class="fa fa-question-circle"></span> Font Awesome fontawesome.com --></span><input
                                                        class="form-control" placeholder="123" name="cvv" maxlength="3"
                                                        pattern="[0-9]{3}" type="text"
                                                        id="bootstrap-wizard-validation-card-cvv"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-validation-tab4"
                                    id="bootstrap-wizard-validation-tab4">
                                    <div class="wizard-lottie-wrapper">
                                        <div class="lottie wizard-lottie mx-auto my-3"
                                            data-options="{&quot;path&quot;:&quot;../../assets/img/animated-icons/celebration.json&quot;}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 464" width="264"
                                                height="464" preserveAspectRatio="xMidYMid meet"
                                                style="width: 100%; height: 100%; transform: translate3d(0px, 0px, 0px);">
                                                <defs>
                                                    <clipPath id="__lottie_element_10">
                                                        <rect width="264" height="464" x="0" y="0"></rect>
                                                    </clipPath>
                                                </defs>
                                                <g clip-path="url(#__lottie_element_10)">
                                                    <g transform="matrix(1,0,0,1,132,232)" opacity="1"
                                                        style="display: block;">
                                                        <g opacity="1" transform="matrix(1,0,0,1,0,147)">
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(203,240,248)"
                                                                                    fill-opacity="1"
                                                                                    d=" M-0.8989999890327454,80.08599853515625 C-0.7940000295639038,80.78700256347656 -0.7200000286102295,81.48899841308594 -0.6759999990463257,82.19000244140625 C-0.34200000762939453,87.56099700927734 -1.4980000257492065,93.02899932861328 -3.9690001010894775,97.80599975585938 C-5.301000118255615,100.37899780273438 -7.017000198364258,101.64800262451172 -10.517999649047852,102.7229995727539 C-11.420000076293945,105.37799835205078 -12.321000099182129,108.03399658203125 -13.111000061035156,109.33300018310547 C-13.656000137329102,110.42500305175781 -14.842000007629395,111.00900268554688 -15.972000122070312,110.91600036621094 C-17.53499984741211,110.55899810791016 -18.777999877929688,109.09200286865234 -18.628999710083008,107.28500366210938 C-18.628999710083008,107.28500366210938 -18.349000930786133,103.89600372314453 -18.349000930786133,103.89600372314453 C-20.174999237060547,103.97200012207031 -22.226999282836914,104.02999877929688 -24.260000228881836,103.86199951171875 C-25.840999603271484,103.73100280761719 -27.19700050354004,103.61900329589844 -28.760000228881836,103.26200103759766 C-28.760000228881836,103.26200103759766 -29.020999908447266,106.42500305175781 -29.020999908447266,106.42500305175781 C-29.170000076293945,108.23200225830078 -30.658000946044922,109.7020034790039 -32.23899841308594,109.57099914550781 C-33.36899948120117,109.47799682617188 -34.44200134277344,108.70700073242188 -34.79999923706055,107.54000091552734 C-35.36600112915039,106.12799835205078 -35.8390007019043,103.58699798583984 -36.31100082397461,101.0459976196289 C-37.946998596191406,100.31199645996094 -39.60300064086914,99.375 -40.85200119018555,98.06600189208984 C-42.0890007019043,96.76899719238281 -42.893001556396484,95.11699676513672 -43.507999420166016,93.45099639892578 C-45.91400146484375,86.9280014038086 -45.12699890136719,78.70800018310547 -41.91999816894531,72.60299682617188 C-38.14099884033203,65.40899658203125 -29.33300018310547,60.678001403808594 -20.74799919128418,61.38800048828125 C-15.503000259399414,61.821998596191406 -10.42300033569336,64.2509994506836 -6.7129998207092285,67.97000122070312 C-3.507999897003174,71.18299865722656 -1.5720000267028809,75.59100341796875 -0.8989999890327454,80.08599853515625z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.7669647336006165,-0.6416893005371094,0.6416893005371094,0.7669647336006165,-56.6051139831543,-6.579689025878906)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M-42.0629997253418,75.07499694824219 C-42.13100051879883,72.34600067138672 -43.540000915527344,62.6150016784668 -43.31999969482422,60.858001708984375 C-43.111000061035156,59.422000885009766 -42.117000579833984,58.492000579833984 -40.979000091552734,58.04999923706055 C-39.20000076293945,57.62900161743164 -37.465999603271484,58.4900016784668 -37.04499816894531,60.26900100708008 C-37.04499816894531,60.26900100708008 -33.599998474121094,71.36100006103516 -33.599998474121094,71.36100006103516">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.6753159165382385,0.7375285625457764,-0.7375285625457764,0.6753159165382385,52.33869552612305,28.72724151611328)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M-1.7050000429153442,77.16000366210938 C-0.7760000228881836,74.59300231933594 1.805999994277954,67.54199981689453 2.1540000438690186,65.80599975585938 C2.4110000133514404,64.37699890136719 1.7619999647140503,63.180999755859375 0.8230000138282776,62.4010009765625 C-0.7300000190734863,61.4379997253418 -2.6480000019073486,61.70500183105469 -3.6110000610351562,63.257999420166016 C-3.6110000610351562,63.257999420166016 -9.840999603271484,71.70099639892578 -9.840999603271484,71.70099639892578">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(1,0,0,0.7300000190734863,0,16.554397583007812)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(36,193,224)" fill-opacity="1"
                                                                            d=" M-18.285999298095703,71.75299835205078 C-18.694000244140625,71.70500183105469 -19.139999389648438,71.98400115966797 -19.187999725341797,72.39199829101562 C-19.22599983215332,72.71600341796875 -19.76300048828125,75.17500305175781 -22.716999053955078,74.87100219726562 C-25.66200065612793,74.48400115966797 -25.614999771118164,71.96800231933594 -25.57699966430664,71.64399719238281 C-25.52899932861328,71.23600006103516 -25.89900016784668,70.86199951171875 -26.30699920654297,70.81400299072266 C-26.71500015258789,70.76599884033203 -27.089000701904297,71.13600158691406 -27.136999130249023,71.54399871826172 C-27.22800064086914,73.02300262451172 -26.492000579833984,75.9219970703125 -22.899999618530273,76.34300231933594 C-22.895999908447266,76.34300231933594 -22.89299964904785,76.34400177001953 -22.888999938964844,76.34400177001953 C-22.88599967956543,76.34500122070312 -22.882999420166016,76.34600067138672 -22.878999710083008,76.34600067138672 C-19.28700065612793,76.76699829101562 -17.900999069213867,74.11499786376953 -17.64699935913086,72.65499877929688 C-17.599000930786133,72.24700164794922 -17.878000259399414,71.8010025024414 -18.285999298095703,71.75299835205078z M-16.341999053955078,65.36100006103516 C-15.125,65.50399780273438 -14.253000259399414,66.60600280761719 -14.395999908447266,67.822998046875 C-14.538999557495117,69.04000091552734 -15.642000198364258,69.91200256347656 -16.858999252319336,69.76899719238281 C-18.076000213623047,69.6259994506836 -18.94700050354004,68.52400207519531 -18.804000854492188,67.30699920654297 C-18.660999298095703,66.08999633789062 -17.55900001525879,65.21800231933594 -16.341999053955078,65.36100006103516z M-27.2810001373291,64.08000183105469 C-26.06399917602539,64.2229995727539 -25.191999435424805,65.32499694824219 -25.334999084472656,66.54199981689453 C-25.47800064086914,67.75900268554688 -26.579999923706055,68.63099670410156 -27.797000885009766,68.48799896240234 C-29.013999938964844,68.34500122070312 -29.88599967956543,67.24299621582031 -29.743000030517578,66.0260009765625 C-29.600000381469727,64.80899810791016 -28.49799919128418,63.9370002746582 -27.2810001373291,64.08000183105469z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(209,226,253)"
                                                                                    fill-opacity="1"
                                                                                    d=" M54.680999755859375,82.1780014038086 C54.84299850463867,82.86799621582031 54.97600173950195,83.56099700927734 55.07699966430664,84.25599670410156 C55.85300064086914,89.58100128173828 55.150001525878906,95.1259994506836 53.08100128173828,100.08999633789062 C51.965999603271484,102.76399993896484 50.361000061035156,104.1709976196289 46.96099853515625,105.53099822998047 C46.28099822998047,108.2509994506836 45.599998474121094,110.97100067138672 44.91999816894531,112.33100128173828 C44.46699905395508,113.46399688720703 43.33300018310547,114.1449966430664 42.20000076293945,114.1449966430664 C40.612998962402344,113.91799926757812 39.25299835205078,112.55899810791016 39.25299835205078,110.74500274658203 C39.25299835205078,110.74500274658203 39.25299835205078,107.34400177001953 39.25299835205078,107.34400177001953 C37.43899917602539,107.57099914550781 35.39899826049805,107.7979965209961 33.35900115966797,107.7979965209961 C31.77199935913086,107.7979965209961 30.41200065612793,107.7979965209961 28.825000762939453,107.57099914550781 C28.825000762939453,107.57099914550781 28.825000762939453,110.74500274658203 28.825000762939453,110.74500274658203 C28.825000762939453,112.55899810791016 27.46500015258789,114.1449966430664 25.878000259399414,114.1449966430664 C24.7450008392334,114.1449966430664 23.611000061035156,113.46399688720703 23.158000946044922,112.33100128173828 C22.47800064086914,110.97100067138672 21.797000885009766,108.47799682617188 21.117000579833984,105.98400115966797 C19.426000595092773,105.38700103759766 17.698999404907227,104.58999633789062 16.34600067138672,103.38800048828125 C15.005999565124512,102.1969985961914 14.069000244140625,100.61799621582031 13.319000244140625,99.00800323486328 C10.383999824523926,92.70500183105469 10.489999771118164,84.447998046875 13.182999610900879,78.0999984741211 C16.35700035095215,70.61900329589844 24.7450008392334,65.17900085449219 33.35900115966797,65.17900085449219 C38.62200164794922,65.17900085449219 43.88399887084961,67.18099975585938 47.88800048828125,70.58200073242188 C51.34700012207031,73.5199966430664 53.63999938964844,77.75399780273438 54.680999755859375,82.1780014038086z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9277806282043457,-0.3731261193752289,0.3731261193752289,0.9277806282043457,-29.038711547851562,11.711593627929688)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M11.956000328063965,83.19000244140625 C11.663999557495117,80.47599792480469 9.456000328063965,70.89399719238281 9.531000137329102,69.125 C9.621000289916992,67.6760025024414 10.53499984741211,66.66899871826172 11.631999969482422,66.13400268554688 C13.369999885559082,65.56800079345703 15.170000076293945,66.28399658203125 15.736000061035156,68.02200317382812 C15.736000061035156,68.02200317382812 20.083999633789062,78.79199981689453 20.083999633789062,78.79199981689453">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9231077432632446,0.3845413625240326,-0.3845413625240326,0.9231077432632446,34.69560241699219,-12.840202331542969)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M54.70100021362305,82.08300018310547 C55.41600036621094,79.447998046875 57.40700149536133,72.20899963378906 57.611000061035156,70.44999694824219 C57.749000549316406,69.00499725341797 57.005001068115234,67.86599731445312 56.005001068115234,67.16600036621094 C54.37699890136719,66.33399963378906 52.48699951171875,66.75800323486328 51.654998779296875,68.38600158691406 C51.654998779296875,68.38600158691406 46.141998291015625,77.31300354003906 46.141998291015625,77.31300354003906">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                            d=" M29.184999465942383,74.53700256347656 C28.781999588012695,74.51599884033203 28.437999725341797,74.9020004272461 28.41699981689453,75.30500030517578 C28.42099952697754,76.76100158691406 29.323999404907227,79.55799865722656 32.87200164794922,79.74500274658203 C36.41999816894531,79.93199920654297 37.612998962402344,77.24600219726562 37.77000045776367,75.79900360107422 C37.85100173950195,75.3219985961914 37.6510009765625,74.98400115966797 37.24800109863281,74.96299743652344 C37.24800109863281,74.96299743652344 29.184999465942383,74.53700256347656 29.184999465942383,74.53700256347656z M38.86899948120117,69.66600036621094 C40.090999603271484,69.76300048828125 41.00299835205078,70.83100128173828 40.90599822998047,72.0530014038086 C40.808998107910156,73.2750015258789 39.74100112915039,74.18699645996094 38.51900100708008,74.08999633789062 C37.297000885009766,73.99299621582031 36.3849983215332,72.92500305175781 36.481998443603516,71.7030029296875 C36.57899856567383,70.48100280761719 37.64699935913086,69.56900024414062 38.86899948120117,69.66600036621094z M27.889999389648438,68.7959976196289 C29.11199951171875,68.89299774169922 30.02400016784668,69.96099853515625 29.927000045776367,71.18299865722656 C29.829999923706055,72.40499877929688 28.761999130249023,73.31700134277344 27.540000915527344,73.22000122070312 C26.31800079345703,73.12300109863281 25.4060001373291,72.05500030517578 25.503000259399414,70.83300018310547 C25.600000381469727,69.61100006103516 26.667999267578125,68.6989974975586 27.889999389648438,68.7959976196289z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(209,226,253)"
                                                                                    fill-opacity="1"
                                                                                    d=" M-55.22200012207031,79.56400299072266 C-55.09600067138672,80.26100158691406 -55,80.96199798583984 -54.93600082397461,81.66100311279297 C-54.44200134277344,87.01899719238281 -55.435001373291016,92.51899719238281 -57.76300048828125,97.36699676513672 C-59.018001556396484,99.97899627685547 -60.69499969482422,101.29900360107422 -64.16200256347656,102.47799682617188 C-64.98400115966797,105.15899658203125 -65.80699920654297,107.83999633789062 -66.55799865722656,109.16200256347656 C-67.06999969482422,110.2699966430664 -68.23799896240234,110.88899993896484 -69.37000274658203,110.8290023803711 C-70.94300079345703,110.51899719238281 -72.2300033569336,109.08899688720703 -72.13400268554688,107.27799987792969 C-72.13400268554688,107.27799987792969 -71.95500183105469,103.88300323486328 -71.95500183105469,103.88300323486328 C-73.77799987792969,104.01399993896484 -75.8270034790039,104.13300323486328 -77.86399841308594,104.0250015258789 C-79.4489974975586,103.94100189208984 -80.80699920654297,103.87000274658203 -82.37999725341797,103.55999755859375 C-82.37999725341797,103.55999755859375 -82.5469970703125,106.72899627685547 -82.5469970703125,106.72899627685547 C-82.64299774169922,108.54000091552734 -84.08399963378906,110.0530014038086 -85.66899871826172,109.96900177001953 C-86.8010025024414,109.90899658203125 -87.89700317382812,109.1709976196289 -88.29000091552734,108.01499938964844 C-88.89700317382812,106.62100219726562 -89.44499969482422,104.09500122070312 -89.99299621582031,101.56900024414062 C-91.6500015258789,100.88400268554688 -93.33399963378906,99.99800109863281 -94.62100219726562,98.72599792480469 C-95.89600372314453,97.46600341796875 -96.75,95.83899688720703 -97.41400146484375,94.19200134277344 C-100.01300048828125,87.74299621582031 -99.47100067138672,79.50299835205078 -96.4469985961914,73.30599975585938 C-92.88300323486328,66.00299835205078 -84.22100067138672,61.01100158691406 -75.61900329589844,61.46500015258789 C-70.36299896240234,61.742000579833984 -65.21399688720703,64.0199966430664 -61.39400100708008,67.62699890136719 C-58.09400177001953,70.74299621582031 -56.02899932861328,75.09100341796875 -55.22200012207031,79.56400299072266z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.7836495637893677,-0.6212031841278076,0.6212031841278076,0.7836495637893677,-67.30817413330078,-42.45275115966797)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M-97.94100189208984,78.3239974975586 C-98.08999633789062,75.5979995727539 -99.79000091552734,65.91400146484375 -99.62200164794922,64.1510009765625 C-99.45600128173828,62.70899963378906 -98.48899841308594,61.750999450683594 -97.36499786376953,61.275001525878906 C-95.5999984741211,60.801998138427734 -93.83999633789062,61.611000061035156 -93.36699676513672,63.375999450683594 C-93.36699676513672,63.375999450683594 -89.59200286865234,74.36000061035156 -89.59200286865234,74.36000061035156">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.7836495637893677,0.6212031841278076,-0.6212031841278076,0.7836495637893677,34.75776290893555,54.57066345214844)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M-55.196998596191406,79.47100067138672 C-54.345001220703125,76.87799835205078 -51.9739990234375,69.75299835205078 -51.678001403808594,68.00700378417969 C-51.4640007019043,66.57099914550781 -52.14699935913086,65.3949966430664 -53.10900115966797,64.64299774169922 C-54.689998626708984,63.72700119018555 -56.60100173950195,64.0510025024414 -57.516998291015625,65.63200378417969 C-57.516998291015625,65.63200378417969 -63.492000579833984,74.25599670410156 -63.492000579833984,74.25599670410156">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(1,0,0,0.75,0,15.995750427246094)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                            d=" M-80.1050033569336,63.73099899291992 C-81.23400115966797,63.55500030517578 -82.35199737548828,64.11599731445312 -82.88700103759766,65.1259994506836 C-82.9990005493164,65.33799743652344 -83.0009994506836,65.58499908447266 -82.89199829101562,65.802001953125 C-82.78199768066406,66.02200317382812 -82.57099914550781,66.17500305175781 -82.3290023803711,66.21299743652344 C-82.01499938964844,66.26200103759766 -81.70099639892578,66.1050033569336 -81.5469970703125,65.82099914550781 C-81.31099700927734,65.38600158691406 -80.82499694824219,65.1449966430664 -80.33699798583984,65.22100067138672 C-79.8489990234375,65.2969970703125 -79.45999908447266,65.67400360107422 -79.36799621582031,66.16000366210938 C-79.30699920654297,66.47699737548828 -79.05599975585938,66.7229995727539 -78.74199676513672,66.77200317382812 C-78.5,66.80999755859375 -78.25199890136719,66.72699737548828 -78.08100128173828,66.5510025024414 C-77.91100311279297,66.37699890136719 -77.83799743652344,66.14099884033203 -77.87999725341797,65.90499877929688 C-78.08200073242188,64.77999877929688 -78.97599792480469,63.90700149536133 -80.1050033569336,63.73099899291992z M-66.40899658203125,67.69200134277344 C-66.61100006103516,66.56700134277344 -67.50499725341797,65.69300079345703 -68.63400268554688,65.51699829101562 C-69.76300048828125,65.34100341796875 -70.87999725341797,65.9020004272461 -71.41500091552734,66.91200256347656 C-71.5270004272461,67.1240005493164 -71.52899932861328,67.37100219726562 -71.41999816894531,67.58799743652344 C-71.30999755859375,67.80799865722656 -71.0999984741211,67.96099853515625 -70.85800170898438,67.9990005493164 C-70.54399871826172,68.0479965209961 -70.2300033569336,67.89099884033203 -70.07599639892578,67.60700225830078 C-69.83999633789062,67.1719970703125 -69.35399627685547,66.93099975585938 -68.86599731445312,67.00700378417969 C-68.37799835205078,67.08300018310547 -67.98799896240234,67.45999908447266 -67.89600372314453,67.94599914550781 C-67.83499908447266,68.26300048828125 -67.58499908447266,68.50900268554688 -67.27100372314453,68.55799865722656 C-67.02899932861328,68.59600067138672 -66.78099822998047,68.51300048828125 -66.60900115966797,68.33699798583984 C-66.43900299072266,68.16300201416016 -66.36699676513672,67.9280014038086 -66.40899658203125,67.69200134277344z M-71.51799774169922,70.24299621582031 C-71.8489990234375,70.19200134277344 -72.15399932861328,70.41600036621094 -72.27200317382812,70.73600006103516 C-72.28199768066406,70.802001953125 -72.76399993896484,73.02899932861328 -75.2770004272461,72.63800048828125 C-77.7239990234375,72.25700378417969 -77.60299682617188,70.177001953125 -77.56199645996094,69.91200256347656 C-77.51100158691406,69.58100128173828 -77.80000305175781,69.26499938964844 -78.13099670410156,69.21399688720703 C-78.46199798583984,69.16300201416016 -78.77799987792969,69.45099639892578 -78.8290023803711,69.78199768066406 C-78.947998046875,70.98300170898438 -78.43900299072266,73.36499786376953 -75.52899932861328,73.81800079345703 C-72.61900329589844,74.27100372314453 -71.40899658203125,72.15699768066406 -71.15799713134766,70.97699737548828 C-70.9739990234375,70.66699981689453 -71.18699645996094,70.29399871826172 -71.51799774169922,70.24299621582031z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(203,240,248)"
                                                                                    fill-opacity="1"
                                                                                    d=" M106.04000091552734,74.5270004272461 C106.322998046875,75.1760025024414 106.5790023803711,75.83599853515625 106.8030014038086,76.5009994506836 C108.52200317382812,81.5999984741211 108.82599639892578,87.18099975585938 107.68199920654297,92.43599700927734 C107.06500244140625,95.26699829101562 105.73799896240234,96.93900299072266 102.63700103759766,98.88700103759766 C102.45600128173828,101.68499755859375 102.2760009765625,104.48300170898438 101.85099792480469,105.94300079345703 C101.60800170898438,107.13899993896484 100.61499786376953,108.01300048828125 99.5,108.21600341796875 C97.89800262451172,108.27799987792969 96.31700134277344,107.18399810791016 95.99099731445312,105.4000015258789 C95.99099731445312,105.4000015258789 95.37999725341797,102.05400085449219 95.37999725341797,102.05400085449219 C93.63700103759766,102.60299682617188 91.66999816894531,103.19200134277344 89.66300201416016,103.55799865722656 C88.10199737548828,103.84300231933594 86.76399993896484,104.08699798583984 85.16200256347656,104.14900207519531 C85.16200256347656,104.14900207519531 85.73200225830078,107.27100372314453 85.73200225830078,107.27100372314453 C86.05799865722656,109.05500030517578 85.00399780273438,110.86100006103516 83.44300079345703,111.14600372314453 C82.3280029296875,111.3489990234375 81.09100341796875,110.88400268554688 80.44200134277344,109.8499984741211 C79.52899932861328,108.63400268554688 78.41200256347656,106.3030014038086 77.29499816894531,103.97200012207031 C75.52400207519531,103.68800354003906 73.68099975585938,103.21499633789062 72.13500213623047,102.2750015258789 C70.60299682617188,101.34400177001953 69.39800262451172,99.95800018310547 68.37100219726562,98.50900268554688 C64.35199737548828,92.83599853515625 62.9739990234375,84.69300079345703 64.48400115966797,77.96499633789062 C66.26300048828125,70.03600311279297 73.53800201416016,63.178001403808594 82.01300048828125,61.63199996948242 C87.19100189208984,60.6870002746582 92.72599792480469,61.71200180053711 97.2760009765625,64.33899688720703 C101.20600128173828,66.60800170898438 104.22100067138672,70.36199951171875 106.04000091552734,74.5270004272461z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.7527701258659363,-0.658283531665802,0.658283531665802,0.7527701258659363,-34.87059020996094,63.90228271484375)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M64.19000244140625,83.19300079345703 C63.415000915527344,80.57499694824219 59.52399826049805,71.5459976196289 59.279998779296875,69.79199981689453 C59.10900115966797,68.35099792480469 59.82699966430664,67.19499969482422 60.81100082397461,66.47200012207031 C62.41899871826172,65.60299682617188 64.31800079345703,65.98400115966797 65.18699645996094,67.59200286865234 C65.18699645996094,67.59200286865234 71.39700317382812,77.40699768066406 71.39700317382812,77.40699768066406">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.8779075145721436,0.4788302481174469,-0.4788302481174469,0.8779075145721436,46.8233757019043,-39.382957458496094)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M106.04299926757812,74.43099975585938 C106.27300262451172,71.71099853515625 106.93199920654297,64.23100280761719 106.81700134277344,62.4640007019043 C106.69400024414062,61.018001556396484 105.75599670410156,60.03200149536133 104.64700317382812,59.52199935913086 C102.89700317382812,58.99599838256836 101.11399841308594,59.75199890136719 100.58799743652344,61.50199890136719 C100.58799743652344,61.50199890136719 96.76699829101562,71.27400207519531 96.76699829101562,71.27400207519531">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(36,193,224)" fill-opacity="1"
                                                                            d=" M85.03199768066406,68.8239974975586 C84.63999938964844,68.9469985961914 84.34600067138672,69.38400268554688 84.46900177001953,69.7760009765625 C84.56600189208984,70.08699798583984 85.08000183105469,72.5510025024414 82.25900268554688,73.47899627685547 C79.41300201416016,74.3270034790039 78.4280014038086,72.01000213623047 78.33100128173828,71.6989974975586 C78.20800018310547,71.30699920654297 77.71800231933594,71.11599731445312 77.32599639892578,71.23899841308594 C76.93399810791016,71.36199951171875 76.74299621582031,71.85199737548828 76.86599731445312,72.24400329589844 C77.38700103759766,73.63099670410156 79.24099731445312,75.97799682617188 82.69200134277344,74.89700317382812 C82.69599914550781,74.89600372314453 82.6989974975586,74.89399719238281 82.7020034790039,74.89299774169922 C82.70500183105469,74.89199829101562 82.70899963378906,74.89199829101562 82.71299743652344,74.89099884033203 C86.16400146484375,73.80999755859375 86.3479995727539,70.822998046875 85.98400115966797,69.38700103759766 C85.86100006103516,68.99500274658203 85.42400360107422,68.70099639892578 85.03199768066406,68.8239974975586z M84.61499786376953,63.027000427246094 C85.78399658203125,62.6609992980957 87.02999877929688,63.3120002746582 87.39600372314453,64.48100280761719 C87.76200103759766,65.6500015258789 87.11100006103516,66.89600372314453 85.94200134277344,67.26200103759766 C84.77300262451172,67.62799835205078 83.5270004272461,66.97699737548828 83.16100311279297,65.80799865722656 C82.79499816894531,64.63899993896484 83.44599914550781,63.393001556396484 84.61499786376953,63.027000427246094z M74.1050033569336,66.31999969482422 C75.27400207519531,65.9540023803711 76.52100372314453,66.6050033569336 76.88700103759766,67.77400207519531 C77.25299835205078,68.94300079345703 76.60099792480469,70.18900299072266 75.43199920654297,70.55500030517578 C74.26300048828125,70.9209976196289 73.01699829101562,70.2699966430664 72.6510009765625,69.10099792480469 C72.28500366210938,67.93199920654297 72.93599700927734,66.68599700927734 74.1050033569336,66.31999969482422z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g opacity="1"
                                                            transform="matrix(0.9826546907424927,0.18544472754001617,-0.18544472754001617,0.9826546907424927,2.9218878746032715,136.84805297851562)">
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(209,226,253)" fill-opacity="1"
                                                                            d=" M22.850000381469727,28.0939998626709 C22.364999771118164,28.86400032043457 21.849000930786133,29.608999252319336 21.30500030517578,30.327999114990234 C17.132999420166016,35.83599853515625 11.428000450134277,40.191001892089844 5.021999835968018,42.770999908447266 C1.5700000524520874,44.1609992980957 -1.1629999876022339,43.95899963378906 -5.4710001945495605,42.07400131225586 C-8.572999954223633,43.90299987792969 -11.673999786376953,45.731998443603516 -13.531000137329102,46.334999084472656 C-14.97599983215332,46.94200134277344 -16.621000289916992,46.518001556396484 -17.642000198364258,45.48099899291992 C-18.864999771118164,43.82500076293945 -18.844999313354492,41.35499954223633 -17.18600082397461,39.72100067138672 C-17.18600082397461,39.72100067138672 -14.076000213623047,36.65700149536133 -14.076000213623047,36.65700149536133 C-15.918000221252441,35.20199966430664 -17.964000701904297,33.540000915527344 -19.802000045776367,31.67300033569336 C-21.23200035095215,30.22100067138672 -22.457000732421875,28.976999282836914 -23.68000030517578,27.320999145507812 C-23.68000030517578,27.320999145507812 -26.58300018310547,30.180999755859375 -26.58300018310547,30.180999755859375 C-28.242000579833984,31.815000534057617 -30.920000076293945,32.000999450683594 -32.349998474121094,30.548999786376953 C-33.37099838256836,29.511999130249023 -33.77000045776367,27.86199951171875 -33.141998291015625,26.426000595092773 C-32.5099983215332,24.577999114990234 -30.840999603271484,21.708999633789062 -29.17300033569336,18.84000015258789 C-30.150999069213867,16.7549991607666 -30.979000091552734,14.456999778747559 -31.097999572753906,12.13599967956543 C-31.215999603271484,9.836999893188477 -30.615999221801758,7.556000232696533 -29.819000244140625,5.419000148773193 C-26.697999954223633,-2.946000099182129 -19.04800033569336,-10.288999557495117 -10.814000129699707,-13.545000076293945 C-1.1100000143051147,-17.382999420166016 11.425999641418457,-14.612000465393066 19.187999725341797,-6.730999946594238 C23.93000030517578,-1.9160000085830688 26.84000015258789,4.702000141143799 27.336999893188477,11.430000305175781 C27.766000747680664,17.242000579833984 25.958999633789062,23.155000686645508 22.850000381469727,28.0939998626709z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(0.5575804114341736,-0.8301229476928711,0.8301229476928711,0.5575804114341736,-5.582985877990723,-13.023871421813965)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(209,226,253)" fill-opacity="1"
                                                                            d=" M-7.302999973297119,-6.633999824523926 C-7.302999973297119,-6.633999824523926 -7.98199987411499,-21.533000946044922 -7.98199987411499,-21.533000946044922 C-7.927000045776367,-23.878999710083008 -9.803000450134277,-25.511999130249023 -12.14900016784668,-25.566999435424805 C-13.706000328063965,-25.386999130249023 -15.243000030517578,-24.55699920654297 -15.968999862670898,-22.84000015258789 C-16.812999725341797,-20.729000091552734 -18.22100067138672,-8.180000305175781 -19.023000717163086,-4.76800012588501 C-19.023000717163086,-4.76800012588501 -7.302999973297119,-6.633999824523926 -7.302999973297119,-6.633999824523926z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(0.7729949355125427,0.6344121694564819,-0.6344121694564819,0.7729949355125427,19.75469398498535,-9.25654411315918)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(209,226,253)" fill-opacity="1"
                                                                            d=" M22.694000244140625,16.281999588012695 C22.694000244140625,16.281999588012695 19.381999969482422,28.62700080871582 19.381999969482422,28.62700080871582 C22.832000732421875,29.24799919128418 32.314998626708984,30.990999221801758 34.5880012512207,31.055999755859375 C36.45199966430664,31.07200050354004 37.82500076293945,29.993000030517578 38.61000061035156,28.63599967956543 C39.49300003051758,26.461000442504883 38.742000579833984,24.090999603271484 36.56700134277344,23.20800018310547 C36.56700134277344,23.20800018310547 22.694000244140625,16.281999588012695 22.694000244140625,16.281999588012695">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                        d=" M-1.2269999980926514,-1.253999948501587 C-1.4980000257492065,-1.5800000429153442 -2.0429999828338623,-1.5700000524520874 -2.36899995803833,-1.2990000247955322 C-3.490000009536743,-0.25699999928474426 -5.004000186920166,2.437000036239624 -2.615999937057495,5.309999942779541 C-0.2280000001192093,8.182999610900879 2.697000026702881,7.188000202178955 3.927000045776367,6.276000022888184 C4.353000164031982,5.999000072479248 4.4710001945495605,5.6020002365112305 4.199999809265137,5.276000022888184 C4.199999809265137,5.276000022888184 -1.2269999980926514,-1.253999948501587 -1.2269999980926514,-1.253999948501587z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(25,118,210)" fill-opacity="1"
                                                                        d=" M-3.5950000286102295,0.5690000057220459 C-4.074999809265137,1.8559999465942383 -4.079999923706055,3.5480000972747803 -2.615999937057495,5.309999942779541 C-1.7510000467300415,6.349999904632568 -0.8180000185966492,6.879000186920166 0.0820000022649765,7.0920000076293945 C0.17299999296665192,6.692999839782715 0.22599999606609344,6.28000020980835 0.22599999606609344,5.853000164031982 C0.22599999606609344,3.3889999389648438 -1.3769999742507935,1.3020000457763672 -3.5950000286102295,0.5690000057220459z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(225,247,249)" fill-opacity="1"
                                                                        d=" M23.834999084472656,10.664999961853027 C23.23699951171875,10.83899974822998 22.854999542236328,11.383000373840332 22.93000030517578,12.010000228881836 C23.347999572753906,15.670000076293945 20.679000854492188,17.636999130249023 20.679000854492188,17.636999130249023 C20.040000915527344,18.038999557495117 19.944000244140625,18.823999404907227 20.34600067138672,19.46299934387207 C20.74799919128418,20.101999282836914 21.533000946044922,20.19700050354004 22.172000885009766,19.795000076293945 C22.341999053955078,19.636999130249023 26.09000015258789,16.923999786376953 25.565000534057617,11.781999588012695 C25.461000442504883,11.055999755859375 24.888999938964844,10.574000358581543 24.163000106811523,10.678000450134277 C24.034000396728516,10.607000350952148 23.934999465942383,10.63599967956543 23.834999084472656,10.664999961853027z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(255,167,38)" fill-opacity="1"
                                                                        d=" M19.1560001373291,9.093999862670898 C15.958999633789062,12.027999877929688 10.989999771118164,11.8149995803833 8.055999755859375,8.618000030517578 C5.122000217437744,5.421000003814697 5.335000038146973,0.4519999921321869 8.531999588012695,-2.4820001125335693 C11.729000091552734,-5.415999889373779 16.697999954223633,-5.203000068664551 19.631999969482422,-2.00600004196167 C22.56599998474121,1.190999984741211 22.35300064086914,6.159999847412109 19.1560001373291,9.093999862670898z M6.388999938964844,-4.816999912261963 C3.191999912261963,-1.8830000162124634 -1.7769999504089355,-2.0969998836517334 -4.710999965667725,-5.294000148773193 C-7.644999980926514,-8.491000175476074 -7.432000160217285,-13.460000038146973 -4.235000133514404,-16.393999099731445 C-1.0379999876022339,-19.327999114990234 3.930999994277954,-19.11400032043457 6.864999771118164,-15.916999816894531 C9.798999786376953,-12.720000267028809 9.586000442504883,-7.750999927520752 6.388999938964844,-4.816999912261963z M9.54699993133545,-0.1979999989271164 C9.54699993133545,-0.1979999989271164 4.315999984741211,-5.896999835968018 4.315999984741211,-5.896999835968018 C4.315999984741211,-5.896999835968018 6.343999862670898,-7.757999897003174 6.343999862670898,-7.757999897003174 C6.343999862670898,-7.757999897003174 11.574999809265137,-2.059000015258789 11.574999809265137,-2.059000015258789 C11.574999809265137,-2.059000015258789 9.54699993133545,-0.1979999989271164 9.54699993133545,-0.1979999989271164z M23.389999389648438,3.885999917984009 C23.389999389648438,4.690999984741211 22.73699951171875,5.343999862670898 21.93199920654297,5.343999862670898 C21.12700080871582,5.343999862670898 20.474000930786133,4.690999984741211 20.474000930786133,3.885999917984009 C20.474000930786133,3.0810000896453857 21.12700080871582,2.427999973297119 21.93199920654297,2.427999973297119 C22.73699951171875,2.427999973297119 23.389999389648438,3.0810000896453857 23.389999389648438,3.885999917984009z M2.13100004196167,-18.613000869750977 C2.13100004196167,-17.808000564575195 1.4780000448226929,-17.15399932861328 0.6729999780654907,-17.15399932861328 C-0.13199999928474426,-17.15399932861328 -0.7860000133514404,-17.808000564575195 -0.7860000133514404,-18.613000869750977 C-0.7860000133514404,-19.417999267578125 -0.13199999928474426,-20.070999145507812 0.6729999780654907,-20.070999145507812 C1.4780000448226929,-20.070999145507812 2.13100004196167,-19.417999267578125 2.13100004196167,-18.613000869750977z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                        d=" M17.871000289916992,7.693999767303467 C15.446999549865723,9.918000221252441 11.680000305175781,9.756999969482422 9.456000328063965,7.333000183105469 C7.23199987411499,4.908999919891357 7.392000198364258,1.1410000324249268 9.815999984741211,-1.0829999446868896 C12.239999771118164,-3.306999921798706 16.007999420166016,-3.1459999084472656 18.23200035095215,-0.722000002861023 C20.45599937438965,1.7020000219345093 20.295000076293945,5.46999979019165 17.871000289916992,7.693999767303467z M5.104000091552734,-6.2170000076293945 C2.680000066757202,-3.993000030517578 -1.0870000123977661,-4.1539998054504395 -3.311000108718872,-6.578000068664551 C-5.534999847412109,-9.001999855041504 -5.374000072479248,-12.770000457763672 -2.950000047683716,-14.994000434875488 C-0.5260000228881836,-17.218000411987305 3.240999937057495,-17.05699920654297 5.465000152587891,-14.633000373840332 C7.689000129699707,-12.208999633789062 7.5279998779296875,-8.440999984741211 5.104000091552734,-6.2170000076293945z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="0.3" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(255,255,255)" fill-opacity="1"
                                                                        d=" M-4.666999816894531,-9.097999572753906 C-4.427999973297119,-8.194000244140625 -4,-7.328000068664551 -3.3239998817443848,-6.591000080108643 C-2.74399995803833,-5.959000110626221 -2.053999900817871,-5.488999843597412 -1.315000057220459,-5.166999816894531 C-1.315000057220459,-5.166999816894531 6.163000106811523,-7.5920000076293945 6.163000106811523,-7.5920000076293945 C7.125999927520752,-9.21500015258789 7.263000011444092,-11.190999984741211 6.534999847412109,-12.920999526977539 C6.534999847412109,-12.920999526977539 -4.666999816894531,-9.097999572753906 -4.666999816894531,-9.097999572753906z M8.112000465393066,4.826000213623047 C8.35099983215332,5.730000019073486 8.779999732971191,6.5960001945495605 9.456000328063965,7.333000183105469 C10.03600025177002,7.965000152587891 10.725000381469727,8.435999870300293 11.46399974822998,8.758000373840332 C11.46399974822998,8.758000373840332 18.941999435424805,6.333000183105469 18.941999435424805,6.333000183105469 C19.905000686645508,4.710000038146973 20.04199981689453,2.7339999675750732 19.31399917602539,1.003999948501587 C19.31399917602539,1.003999948501587 8.112000465393066,4.826000213623047 8.112000465393066,4.826000213623047z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                            <g opacity="1"
                                                                transform="matrix(0.2817941904067993,0.9594748616218567,-0.9594748616218567,0.2817941904067993,52.038124084472656,-52.39561462402344)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(203,240,248)" fill-opacity="1"
                                                                            d=" M46.28300094604492,-9.434000015258789 C46.28300094604492,-9.434000015258789 29.57900047302246,-8.812999725341797 29.57900047302246,-8.812999725341797 C29.1560001373291,-8.79699993133545 28.878000259399414,-8.366999626159668 29.03700065612793,-7.974999904632568 C29.03700065612793,-7.974999904632568 30.96500015258789,-3.2279999256134033 30.96500015258789,-3.2279999256134033 C30.96500015258789,-3.2279999256134033 31.507999420166016,-1.8919999599456787 31.507999420166016,-1.8919999599456787 C31.507999420166016,-1.8919999599456787 33.43600082397461,2.8519999980926514 33.43600082397461,2.8519999980926514 C33.59600067138672,3.244999885559082 34.095001220703125,3.359999895095825 34.409000396728516,3.075000047683716 C36.5880012512207,1.093999981880188 43.7140007019043,-5.385000228881836 46.79399871826172,-8.190999984741211 C47.2869987487793,-8.640999794006348 46.95000076293945,-9.458999633789062 46.28300094604492,-9.434000015258789z">
                                                                        </path>
                                                                    </g>
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(148,219,224)" fill-opacity="1"
                                                                            d=" M30.836999893188477,-3.5429999828338623 C30.836999893188477,-3.5429999828338623 38.24700164794922,-0.41499999165534973 38.24700164794922,-0.41499999165534973 C39.04600143432617,-1.1410000324249268 39.895999908447266,-1.9140000343322754 40.75199890136719,-2.693000078201294 C40.75199890136719,-2.693000078201294 29.20199966430664,-7.570000171661377 29.20199966430664,-7.570000171661377 C29.20199966430664,-7.570000171661377 30.836999893188477,-3.5429999828338623 30.836999893188477,-3.5429999828338623z">
                                                                        </path>
                                                                    </g>
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(148,219,224)" fill-opacity="1"
                                                                            d=" M34.09600067138672,-8.980999946594238 C34.09600067138672,-8.980999946594238 43.36399841308594,-5.067999839782715 43.36399841308594,-5.067999839782715 C44.27899932861328,-5.901000022888184 45.13399887084961,-6.678999900817871 45.86800003051758,-7.3470001220703125 C45.86800003051758,-7.3470001220703125 41.356998443603516,-9.25100040435791 41.356998443603516,-9.25100040435791 C41.356998443603516,-9.25100040435791 34.09600067138672,-8.980999946594238 34.09600067138672,-8.980999946594238z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(148,219,224)" fill-opacity="1"
                                                                        d=" M50.084999084472656,-9.02400016784668 C49.917999267578125,-7.9670000076293945 48.92499923706055,-7.245999813079834 47.86800003051758,-7.413000106811523 C46.81100082397461,-7.579999923706055 46.09000015258789,-8.572999954223633 46.25699996948242,-9.630000114440918 C46.42399978637695,-10.687000274658203 47.41699981689453,-11.407999992370605 48.4739990234375,-11.241000175476074 C49.53099822998047,-11.074000358581543 50.25199890136719,-10.081000328063965 50.084999084472656,-9.02400016784668z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g opacity="1" transform="matrix(1,0,0,1,0,147)">
                                                            <g opacity="0" transform="matrix(1,0,0,1,-25,24)">
                                                                <path fill="rgb(246,102,56)" fill-opacity="1"
                                                                    d=" M62.60100173950195,18.645999908447266 C60.78099822998047,23.586000442504883 56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 C56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 C56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 C56.1879997253418,24.972999572753906 60.867000579833984,26.358999252319336 62.513999938964844,31.298999786376953 C64.33399963378906,26.358999252319336 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.927001953125,24.972999572753906 64.24800109863281,23.586000442504883 62.60100173950195,18.645999908447266">
                                                                </path>
                                                            </g>
                                                            <g opacity="0"
                                                                transform="matrix(0.5150380730628967,0.8571673035621643,-0.8571673035621643,0.5150380730628967,12.08004379272461,76.05459594726562)">
                                                                <path fill="rgb(253,202,64)" fill-opacity="1"
                                                                    d=" M-61.39899826049805,42.3129997253418 C-63.21900177001953,47.25299835205078 -67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 C-67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 C-67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 C-67.81199645996094,48.638999938964844 -63.132999420166016,50.0260009765625 -61.486000061035156,54.965999603271484 C-59.66600036621094,50.0260009765625 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.073001861572266,48.638999938964844 -59.75199890136719,47.25299835205078 -61.39899826049805,42.3129997253418">
                                                                </path>
                                                            </g>
                                                            <g opacity="0" transform="matrix(1,0,0,1,0,0)">
                                                                <path fill="rgb(253,202,64)" fill-opacity="1"
                                                                    d=" M29.243999481201172,-37.02000045776367 C27.90399932861328,-33.38199996948242 24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 C24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 C24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 C24.520999908447266,-32.36000061035156 27.966999053955078,-31.339000701904297 29.18000030517578,-27.701000213623047 C30.520000457763672,-31.339000701904297 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.90399932861328,-32.36000061035156 30.457000732421875,-33.38199996948242 29.243999481201172,-37.02000045776367">
                                                                </path>
                                                            </g>
                                                            <g opacity="0" transform="matrix(1,0,0,1,0,0)">
                                                                <path fill="rgb(246,102,56)" fill-opacity="1"
                                                                    d=" M-54.15999984741211,-6.0269999504089355 C-55.42100143432617,-2.6040000915527344 -58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 C-58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 C-58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 C-58.604000091552734,-1.6430000066757202 -55.361000061035156,-0.6819999814033508 -54.220001220703125,2.740999937057495 C-52.95899963378906,-0.6819999814033508 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.775001525878906,-1.6430000066757202 -53.01900100708008,-2.6040000915527344 -54.15999984741211,-6.0269999504089355">
                                                                </path>
                                                            </g>
                                                            <g opacity="0"
                                                                transform="matrix(0.9131986498832703,-0.793831467628479,0.793831467628479,0.9131986498832703,-8.248411178588867,0.6842203140258789)">
                                                                <path fill="rgb(255,255,255)" fill-opacity="1"
                                                                    d=" M-42.262001037597656,-30.163000106811523 C-41.54399871826172,-29.516000747680664 -41.487998962402344,-28.409000396728516 -42.1349983215332,-27.69099998474121 C-42.78200149536133,-26.972999572753906 -43.88800048828125,-26.91699981689453 -44.60599899291992,-27.56399917602539 M47.02899932861328,50.5369987487793 C48.38600158691406,49.99800109863281 49.92499923706055,50.6609992980957 50.4640007019043,52.018001556396484 C51.00299835205078,53.375 50.34000015258789,54.91299819946289 48.983001708984375,55.45199966430664">
                                                                </path>
                                                                <path fill="rgb(255,213,79)" fill-opacity="1"
                                                                    d=" M47.02899932861328,50.5369987487793 C48.38600158691406,49.99800109863281 49.92499923706055,50.6609992980957 50.4640007019043,52.018001556396484 C51.00299835205078,53.375 50.34000015258789,54.91299819946289 48.983001708984375,55.45199966430664">
                                                                </path>
                                                            </g>
                                                            <g opacity="0"
                                                                transform="matrix(0.9612616896629333,0.27563735842704773,-0.27563735842704773,0.9612616896629333,0,0)">
                                                                <path fill="rgb(255,213,79)" fill-opacity="1"
                                                                    d=" M73.93099975585938,-6.883999824523926 C74.88200378417969,-6.291999816894531 75.1719970703125,-5.040999889373779 74.58000183105469,-4.090000152587891 C73.98799896240234,-3.1389999389648438 72.73699951171875,-2.8480000495910645 71.78600311279297,-3.440000057220459">
                                                                </path>
                                                            </g>
                                                            <g opacity="0" transform="matrix(1,0,0,1,0,-11)">
                                                                <path fill="rgb(255,213,79)" fill-opacity="1"
                                                                    d=" M69.44400024414062,41.17900085449219 C69.44400024414062,42.18000030517578 68.63200378417969,42.992000579833984 67.63099670410156,42.992000579833984 C66.62999725341797,42.992000579833984 65.81800079345703,42.18000030517578 65.81800079345703,41.17900085449219 C65.81800079345703,40.178001403808594 66.62999725341797,39.36600112915039 67.63099670410156,39.36600112915039 C68.63200378417969,39.36600112915039 69.44400024414062,40.178001403808594 69.44400024414062,41.17900085449219z">
                                                                </path>
                                                            </g>
                                                            <g opacity="0" transform="matrix(1,0,0,1,-14,-38)">
                                                                <path fill="rgb(245,245,245)" fill-opacity="1"
                                                                    d=" M-53.305999755859375,27.448999404907227 C-53.305999755859375,28.450000762939453 -54.11800003051758,29.261999130249023 -55.11899948120117,29.261999130249023 C-56.119998931884766,29.261999130249023 -56.93199920654297,28.450000762939453 -56.93199920654297,27.448999404907227 C-56.93199920654297,26.447999954223633 -56.119998931884766,25.63599967956543 -55.11899948120117,25.63599967956543 C-54.11800003051758,25.63599967956543 -53.305999755859375,26.447999954223633 -53.305999755859375,27.448999404907227z">
                                                                </path>
                                                            </g>
                                                            <g opacity="0"
                                                                transform="matrix(0.9063078165054321,-0.4226182699203491,0.4226182699203491,0.9063078165054321,-1.9754083156585693,0.057509422302246094)">
                                                                <path fill="rgb(52,168,83)" fill-opacity="1"
                                                                    d=" M-53.867000579833984,-20.260000228881836 C-53.867000579833984,-19.259000778198242 -54.67900085449219,-18.445999145507812 -55.68000030517578,-18.445999145507812 C-56.680999755859375,-18.445999145507812 -57.49300003051758,-19.259000778198242 -57.49300003051758,-20.260000228881836 C-57.49300003051758,-21.26099967956543 -56.680999755859375,-22.072999954223633 -55.68000030517578,-22.072999954223633 C-54.67900085449219,-22.072999954223633 -53.867000579833984,-21.26099967956543 -53.867000579833984,-20.260000228881836z M53.694000244140625,-25.40399932861328 C53.694000244140625,-24.402999877929688 52.88199996948242,-23.590999603271484 51.88100051879883,-23.590999603271484 C50.880001068115234,-23.590999603271484 50.06800079345703,-24.402999877929688 50.06800079345703,-25.40399932861328 C50.06800079345703,-26.405000686645508 50.880001068115234,-27.216999053955078 51.88100051879883,-27.216999053955078 C52.88199996948242,-27.216999053955078 53.694000244140625,-26.405000686645508 53.694000244140625,-25.40399932861328z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg></div>
                                    </div>
                                    <h4 class="mb-1">Your account is all set!</h4>
                                    <p>Now you can access to your account</p><a class="btn btn-primary px-5 my-3"
                                        href="../../modules/forms/wizard.html">Start Over</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="px-sm-3 px-md-5">
                                <ul class="pager wizard list-inline mb-0">
                                    <li class="previous"><button class="btn btn-link ps-0 d-none" type="button"><svg
                                                class="svg-inline--fa fa-chevron-left fa-w-10 me-2"
                                                data-fa-transform="shrink-3" aria-hidden="true" focusable="false"
                                                data-prefix="fas" data-icon="chevron-left" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;">
                                                <g transform="translate(160 256)">
                                                    <g
                                                        transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                        <path fill="currentColor"
                                                            d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"
                                                            transform="translate(-160 -256)"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <!-- <span class="fas fa-chevron-left me-2" data-fa-transform="shrink-3"></span> Font Awesome fontawesome.com -->Prev</button>
                                    </li>
                                    <li class="next"><button class="btn btn-primary px-5 px-sm-6" type="submit">Next<svg
                                                class="svg-inline--fa fa-chevron-right fa-w-10 ms-2"
                                                data-fa-transform="shrink-3" aria-hidden="true" focusable="false"
                                                data-prefix="fas" data-icon="chevron-right" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;">
                                                <g transform="translate(160 256)">
                                                    <g
                                                        transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                        <path fill="currentColor"
                                                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"
                                                            transform="translate(-160 -256)"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <!-- <span class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3"> </span> Font Awesome fontawesome.com --></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
                        <div class="modal-content position-relative p-5">
                            <div class="d-flex align-items-center">
                                <div class="lottie me-3"
                                    data-options="{&quot;path&quot;:&quot;../../assets/img/animated-icons/warning-light.json&quot;}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32"
                                        preserveAspectRatio="xMidYMid meet"
                                        style="width: 100%; height: 100%; transform: translate3d(0px, 0px, 0px);">
                                        <defs>
                                            <clipPath id="__lottie_element_14">
                                                <rect width="32" height="32" x="0" y="0"></rect>
                                            </clipPath>
                                        </defs>
                                        <g clip-path="url(#__lottie_element_14)">
                                            <g transform="matrix(1.5870167016983032,0,0,1.5870167016983032,2.9071121215820312,2.9071121215820312)"
                                                opacity="0.05195342211209294" style="display: none;">
                                                <g opacity="1" transform="matrix(1,0,0,1,8.25,8.25)">
                                                    <path fill="rgb(254,240,232)" fill-opacity="1"
                                                        d=" M-8,0 C-8,4.415999889373779 -4.415999889373779,8 0,8 C4.415999889373779,8 8,4.415999889373779 8,0 C8,-4.415999889373779 4.415999889373779,-8 0,-8 C-4.415999889373779,-8 -8,-4.415999889373779 -8,0z">
                                                    </path>
                                                </g>
                                            </g>
                                            <g transform="matrix(1.0022101402282715,0,0,1.0022101402282715,7.731766700744629,7.731766700744629)"
                                                opacity="1" style="display: block;">
                                                <g opacity="1" transform="matrix(1,0,0,1,8.25,8.25)">
                                                    <path fill="rgb(255,227,210)" fill-opacity="1"
                                                        d=" M-8,0 C-8,4.415999889373779 -4.415999889373779,8 0,8 C4.415999889373779,8 8,4.415999889373779 8,0 C8,-4.415999889373779 4.415999889373779,-8 0,-8 C-4.415999889373779,-8 -8,-4.415999889373779 -8,0z">
                                                    </path>
                                                </g>
                                                <g opacity="1" transform="matrix(1,0,0,1,8.25,7.193999767303467)">
                                                    <path fill="rgb(245,128,62)" fill-opacity="1"
                                                        d=" M0,2.5439999103546143 C0.22100000083446503,2.5439999103546143 0.4000000059604645,2.365000009536743 0.4000000059604645,2.1440000534057617 C0.4000000059604645,2.1440000534057617 0.4000000059604645,-2.1440000534057617 0.4000000059604645,-2.1440000534057617 C0.4000000059604645,-2.365000009536743 0.22100000083446503,-2.5439999103546143 0,-2.5439999103546143 C-0.22100000083446503,-2.5439999103546143 -0.4000000059604645,-2.365000009536743 -0.4000000059604645,-2.1440000534057617 C-0.4000000059604645,-2.1440000534057617 -0.4000000059604645,2.1440000534057617 -0.4000000059604645,2.1440000534057617 C-0.4000000059604645,2.365000009536743 -0.22100000083446503,2.5439999103546143 0,2.5439999103546143z">
                                                    </path>
                                                </g>
                                                <g opacity="1" transform="matrix(1,0,0,1,8.25,12.25)">
                                                    <path fill="rgb(245,128,62)" fill-opacity="1"
                                                        d=" M0,-0.800000011920929 C-0.44200000166893005,-0.800000011920929 -0.800000011920929,-0.4429999887943268 -0.800000011920929,0 C-0.800000011920929,0.4410000145435333 -0.44200000166893005,0.800000011920929 0,0.800000011920929 C0.44200000166893005,0.800000011920929 0.800000011920929,0.4410000145435333 0.800000011920929,0 C0.800000011920929,-0.4429999887943268 0.44200000166893005,-0.800000011920929 0,-0.800000011920929z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg></div>
                                <div class="flex-1"><button
                                        class="btn btn-link text-danger position-absolute top-0 end-0 mt-2 me-2"
                                        data-bs-dismiss="modal"><svg class="svg-inline--fa fa-times fa-w-11"
                                            aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times"
                                            role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"
                                            data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z">
                                            </path>
                                        </svg>
                                        <!-- <span class="fas fa-times"></span> Font Awesome fontawesome.com --></button>
                                    <p class="mb-0">You don't have access to the link. Please try again.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5 mt-lg-0 mt-xl-5 mt-xxl-0">
                <div class="col-lg-6 col-xl-12 col-xxl-6 h-100">
                    <div class="d-flex mb-4"><span class="fa-stack me-2 ms-n1"><svg
                                class="svg-inline--fa fa-circle fa-w-16 fa-stack-2x text-300" aria-hidden="true"
                                focusable="false" data-prefix="fas" data-icon="circle" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                            </svg>
                            <!-- <i class="fas fa-circle fa-stack-2x text-300"></i> Font Awesome fontawesome.com --><svg
                                class="svg-inline--fa fa-tasks fa-w-16 fa-inverse fa-stack-1x text-primary"
                                aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tasks" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M139.61 35.5a12 12 0 0 0-17 0L58.93 98.81l-22.7-22.12a12 12 0 0 0-17 0L3.53 92.41a12 12 0 0 0 0 17l47.59 47.4a12.78 12.78 0 0 0 17.61 0l15.59-15.62L156.52 69a12.09 12.09 0 0 0 .09-17zm0 159.19a12 12 0 0 0-17 0l-63.68 63.72-22.7-22.1a12 12 0 0 0-17 0L3.53 252a12 12 0 0 0 0 17L51 316.5a12.77 12.77 0 0 0 17.6 0l15.7-15.69 72.2-72.22a12 12 0 0 0 .09-16.9zM64 368c-26.49 0-48.59 21.5-48.59 48S37.53 464 64 464a48 48 0 0 0 0-96zm432 16H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z">
                                </path>
                            </svg>
                            <!-- <i class="fa-inverse fa-stack-1x text-primary fas fa-tasks"></i> Font Awesome fontawesome.com --></span>
                        <div class="col">
                            <h5 class="mb-0 text-primary position-relative"><span class="bg-200 dark__bg-1100 pe-3">With
                                    progressbar</span><span
                                    class="border position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                            </h5>
                            <p class="mb-0">You can easily show your stats content by using these cards.</p>
                        </div>
                    </div>
                    <div class="card theme-wizard mb-5 mb-lg-0 mb-xl-5 mb-xxl-0 h-100">
                        <div class="card-header bg-light pt-3 pb-2">
                            <ul class="nav nav-pills mb-3" role="tablist" id="pill-tab2">
                                <li class="nav-item" role="presentation"><button class="nav-link active"
                                        data-wizard-step="data-wizard-step" data-bs-toggle="pill"
                                        data-bs-target="#form-wizard-progress-tab1" type="button" role="tab"
                                        aria-controls="form-wizard-progress-tab1" aria-selected="true"><svg
                                            class="svg-inline--fa fa-lock fa-w-14 me-2" data-fa-transform="shrink-2"
                                            aria-hidden="true" focusable="false" data-prefix="fas" data-icon="lock"
                                            role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                            data-fa-i2svg="" style="transform-origin: 0.4375em 0.5em;">
                                            <g transform="translate(224 256)">
                                                <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                    <path fill="currentColor"
                                                        d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"
                                                        transform="translate(-224 -256)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        <!-- <span class="fas fa-lock me-2" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com --><span
                                            class="d-none d-md-inline-block fs--1">Account</span></button></li>
                                <li class="nav-item" role="presentation"><button class="nav-link"
                                        data-wizard-step="data-wizard-step" data-bs-toggle="pill"
                                        data-bs-target="#form-wizard-progress-tab2" type="button" role="tab"
                                        aria-controls="form-wizard-progress-tab2" aria-selected="false"><svg
                                            class="svg-inline--fa fa-user fa-w-14 me-2" data-fa-transform="shrink-2"
                                            aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user"
                                            role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                            data-fa-i2svg="" style="transform-origin: 0.4375em 0.5em;">
                                            <g transform="translate(224 256)">
                                                <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                    <path fill="currentColor"
                                                        d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"
                                                        transform="translate(-224 -256)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        <!-- <span class="fas fa-user me-2" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com --><span
                                            class="d-none d-md-inline-block fs--1">Personal</span></button></li>
                                <li class="nav-item" role="presentation"><button class="nav-link"
                                        data-wizard-step="data-wizard-step" data-bs-toggle="pill"
                                        data-bs-target="#form-wizard-progress-tab3" type="button" role="tab"
                                        aria-controls="form-wizard-progress-tab3" aria-selected="false"><svg
                                            class="svg-inline--fa fa-dollar-sign fa-w-9 me-2"
                                            data-fa-transform="down-2 shrink-2" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="dollar-sign" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 288 512" data-fa-i2svg=""
                                            style="transform-origin: 0.28125em 0.625em;">
                                            <g transform="translate(144 256)">
                                                <g transform="translate(0, 64)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                    <path fill="currentColor"
                                                        d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z"
                                                        transform="translate(-144 -256)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        <!-- <span class="fas fa-dollar-sign me-2" data-fa-transform="down-2 shrink-2"></span> Font Awesome fontawesome.com --><span
                                            class="d-none d-md-inline-block fs--1">Billing</span></button></li>
                                <li class="nav-item" role="presentation"><button class="nav-link"
                                        data-wizard-step="data-wizard-step" data-bs-toggle="pill"
                                        data-bs-target="#form-wizard-progress-tab4" type="button" role="tab"
                                        aria-controls="form-wizard-progress-tab4" aria-selected="false"><svg
                                            class="svg-inline--fa fa-thumbs-up fa-w-16 me-2"
                                            data-fa-transform="shrink-2" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="thumbs-up" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                            style="transform-origin: 0.5em 0.5em;">
                                            <g transform="translate(256 256)">
                                                <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                    <path fill="currentColor"
                                                        d="M104 224H24c-13.255 0-24 10.745-24 24v240c0 13.255 10.745 24 24 24h80c13.255 0 24-10.745 24-24V248c0-13.255-10.745-24-24-24zM64 472c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zM384 81.452c0 42.416-25.97 66.208-33.277 94.548h101.723c33.397 0 59.397 27.746 59.553 58.098.084 17.938-7.546 37.249-19.439 49.197l-.11.11c9.836 23.337 8.237 56.037-9.308 79.469 8.681 25.895-.069 57.704-16.382 74.757 4.298 17.598 2.244 32.575-6.148 44.632C440.202 511.587 389.616 512 346.839 512l-2.845-.001c-48.287-.017-87.806-17.598-119.56-31.725-15.957-7.099-36.821-15.887-52.651-16.178-6.54-.12-11.783-5.457-11.783-11.998v-213.77c0-3.2 1.282-6.271 3.558-8.521 39.614-39.144 56.648-80.587 89.117-113.111 14.804-14.832 20.188-37.236 25.393-58.902C282.515 39.293 291.817 0 312 0c24 0 72 8 72 81.452z"
                                                        transform="translate(-256 -256)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        <!-- <span class="fas fa-thumbs-up me-2" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com --><span
                                            class="d-none d-md-inline-block fs--1">Done</span></button></li>
                            </ul>
                        </div>
                        <div class="progress" style="height: 2px;">
                            <div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0"
                                aria-valuemax="100" style="width: 25%;"></div>
                        </div>
                        <div class="card-body py-4">
                            <div class="tab-content">
                                <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="form-wizard-progress-tab1" id="form-wizard-progress-tab1">
                                    <form novalidate="novalidate">
                                        <div class="mb-3"><label class="form-label"
                                                for="form-wizard-progress-wizard-name">Name</label><input
                                                class="form-control" type="text" name="name" placeholder="John Smith"
                                                id="form-wizard-progress-wizard-name"></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="form-wizard-progress-wizard-email">Email*</label><input
                                                class="form-control" type="email" name="email"
                                                placeholder="Email address"
                                                pattern="^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$"
                                                required="required" id="form-wizard-progress-wizard-email"
                                                data-wizard-validate-email="true">
                                            <div class="invalid-feedback">You must add email</div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="form-wizard-progress-wizard-password">Password*</label><input
                                                        class="form-control" type="password" name="password"
                                                        placeholder="Password" required="required"
                                                        id="form-wizard-progress-wizard-password"
                                                        data-wizard-validate-password="true">
                                                    <div class="invalid-feedback">Please enter password</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="form-wizard-progress-wizard-confirm-password">Confirm
                                                        Password*</label><input class="form-control" type="password"
                                                        name="confirmPassword" placeholder="Confirm Password"
                                                        required="required"
                                                        id="form-wizard-progress-wizard-confirm-password"
                                                        data-wizard-validate-confirm-password="true">
                                                    <div class="invalid-feedback">Passwords need to match</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox"
                                                name="terms" required="required" checked="checked"
                                                id="form-wizard-progress-wizard-checkbox"><label
                                                class="form-check-label" for="form-wizard-progress-wizard-checkbox">I
                                                accept the <a href="#!">terms </a>and <a href="#!">privacy
                                                    policy</a></label></div>
                                    </form>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="form-wizard-progress-tab2" id="form-wizard-progress-tab2">
                                    <form>
                                        <div class="mb-3">
                                            <div class="row dz-clickable" data-dropzone="data-dropzone"
                                                data-options="{&quot;maxFiles&quot;:1,&quot;data&quot;:[{&quot;name&quot;:&quot;avatar.png&quot;,&quot;size&quot;:&quot;54kb&quot;,&quot;url&quot;:&quot;../../assets/img/team&quot;}]}">

                                                <div class="col-md-auto">
                                                    <div class="dz-preview dz-preview-single">
                                                        <div
                                                            class="dz-preview-cover d-flex align-items-center justify-content-center mb-3 mb-md-0 dz-image-preview">
                                                            <div class="avatar avatar-4xl"><img class="rounded-circle"
                                                                    src="../../assets/img/team/avatar.png"
                                                                    alt="avatar.png"
                                                                    data-dz-thumbnail="data-dz-thumbnail"></div>
                                                            <div class="dz-progress"><span class="dz-upload"
                                                                    data-dz-uploadprogress=""></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <div class="dz-message dropzone-area px-2 py-3"
                                                        data-dz-message="data-dz-message">
                                                        <div class="text-center"><img class="me-2"
                                                                src="../../assets/img/icons/cloud-upload.svg" width="25"
                                                                alt="">Upload your profile picture<p
                                                                class="mb-0 fs--1 text-400">Upload a 300x300 jpg image
                                                                with <br>a maximum size of 400KB</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3"><label class="form-label"
                                                for="form-wizard-progress-gender">Gender</label><select
                                                class="form-select" name="gender" id="form-wizard-progress-gender">
                                                <option value="">Select your gender ...</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="form-wizard-progress-wizard-phone">Phone</label><input
                                                class="form-control" type="text" name="phone" placeholder="Phone"
                                                id="form-wizard-progress-wizard-phone"></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="form-wizard-progress-wizard-datepicker">Date of Birth</label><input
                                                class="form-control datetimepicker flatpickr-input" type="text"
                                                placeholder="d/m/y"
                                                data-options="{&quot;dateFormat&quot;:&quot;d/m/y&quot;,&quot;disableMobile&quot;:true}"
                                                id="form-wizard-progress-wizard-datepicker" readonly="readonly"></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="form-wizard-progress-wizard-address">Address</label><textarea
                                                class="form-control" rows="4"
                                                id="form-wizard-progress-wizard-address"></textarea></div>
                                    </form>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="form-wizard-progress-tab3" id="form-wizard-progress-tab3">
                                    <form class="form-validation">
                                        <div class="row g-2">
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label"
                                                        for="form-wizard-progress-card-number">Card Number</label><input
                                                        class="form-control" placeholder="XXXX XXXX XXXX XXXX"
                                                        type="text" id="form-wizard-progress-card-number"></div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label"
                                                        for="form-wizard-progress-card-name">Name on Card</label><input
                                                        class="form-control" placeholder="John Doe" name="cardName"
                                                        type="text" id="form-wizard-progress-card-name"></div>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="form-wizard-progress-card-holder-country">Country</label><select
                                                        class="form-select" name="customSelectCountry"
                                                        id="form-wizard-progress-card-holder-country">
                                                        <option value="">Select your country ...</option>
                                                        <option value="Afghanistan">Afghanistan</option>
                                                        <option value="Albania">Albania</option>
                                                        <option value="Algeria">Algeria</option>
                                                        <option value="American Samoa">American Samoa</option>
                                                        <option value="Andorra">Andorra</option>
                                                        <option value="Angola">Angola</option>
                                                        <option value="Anguilla">Anguilla</option>
                                                        <option value="Antarctica">Antarctica</option>
                                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                        <option value="Argentina">Argentina</option>
                                                        <option value="Armenia">Armenia</option>
                                                        <option value="Aruba">Aruba</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Austria">Austria</option>
                                                        <option value="Azerbaijan">Azerbaijan</option>
                                                        <option value="Bahamas">Bahamas</option>
                                                        <option value="Bahrain">Bahrain</option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                        <option value="Barbados">Barbados</option>
                                                        <option value="Belarus">Belarus</option>
                                                        <option value="Belgium">Belgium</option>
                                                        <option value="Belize">Belize</option>
                                                        <option value="Benin">Benin</option>
                                                        <option value="Bermuda">Bermuda</option>
                                                        <option value="Bhutan">Bhutan</option>
                                                        <option value="Bolivia">Bolivia</option>
                                                        <option value="Bosnia and Herzegowina">Bosnia and Herzegowina
                                                        </option>
                                                        <option value="Botswana">Botswana</option>
                                                        <option value="Bouvet Island">Bouvet Island</option>
                                                        <option value="Brazil">Brazil</option>
                                                        <option value="British Indian Ocean Territory">British Indian
                                                            Ocean Territory</option>
                                                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                        <option value="Bulgaria">Bulgaria</option>
                                                        <option value="Burkina Faso">Burkina Faso</option>
                                                        <option value="Burundi">Burundi</option>
                                                        <option value="Cambodia">Cambodia</option>
                                                        <option value="Cameroon">Cameroon</option>
                                                        <option value="Canada">Canada</option>
                                                        <option value="Cape Verde">Cape Verde</option>
                                                        <option value="Cayman Islands">Cayman Islands</option>
                                                        <option value="Central African Republic">Central African
                                                            Republic</option>
                                                        <option value="Chad">Chad</option>
                                                        <option value="Chile">Chile</option>
                                                        <option value="China">China</option>
                                                        <option value="Christmas Island">Christmas Island</option>
                                                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands
                                                        </option>
                                                        <option value="Colombia">Colombia</option>
                                                        <option value="Comoros">Comoros</option>
                                                        <option value="Congo">Congo</option>
                                                        <option value="Congo, the Democratic Republic of the">Congo, the
                                                            Democratic Republic of the</option>
                                                        <option value="Cook Islands">Cook Islands</option>
                                                        <option value="Costa Rica">Costa Rica</option>
                                                        <option value="Cote d'Ivoire">Cote d'Ivoire</option>
                                                        <option value="Croatia (Hrvatska)">Croatia (Hrvatska)</option>
                                                        <option value="Cuba">Cuba</option>
                                                        <option value="Cyprus">Cyprus</option>
                                                        <option value="Czech Republic">Czech Republic</option>
                                                        <option value="Denmark">Denmark</option>
                                                        <option value="Djibouti">Djibouti</option>
                                                        <option value="Dominica">Dominica</option>
                                                        <option value="Dominican Republic">Dominican Republic</option>
                                                        <option value="East Timor">East Timor</option>
                                                        <option value="Ecuador">Ecuador</option>
                                                        <option value="Egypt">Egypt</option>
                                                        <option value="El Salvador">El Salvador</option>
                                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                        <option value="Eritrea">Eritrea</option>
                                                        <option value="Estonia">Estonia</option>
                                                        <option value="Ethiopia">Ethiopia</option>
                                                        <option value="Falkland Islands (Malvinas)">Falkland Islands
                                                            (Malvinas)</option>
                                                        <option value="Faroe Islands">Faroe Islands</option>
                                                        <option value="Fiji">Fiji</option>
                                                        <option value="Finland">Finland</option>
                                                        <option value="France">France</option>
                                                        <option value="France Metropolitan">France Metropolitan</option>
                                                        <option value="French Guiana">French Guiana</option>
                                                        <option value="French Polynesia">French Polynesia</option>
                                                        <option value="French Southern Territories">French Southern
                                                            Territories</option>
                                                        <option value="Gabon">Gabon</option>
                                                        <option value="Gambia">Gambia</option>
                                                        <option value="Georgia">Georgia</option>
                                                        <option value="Germany">Germany</option>
                                                        <option value="Ghana">Ghana</option>
                                                        <option value="Gibraltar">Gibraltar</option>
                                                        <option value="Greece">Greece</option>
                                                        <option value="Greenland">Greenland</option>
                                                        <option value="Grenada">Grenada</option>
                                                        <option value="Guadeloupe">Guadeloupe</option>
                                                        <option value="Guam">Guam</option>
                                                        <option value="Guatemala">Guatemala</option>
                                                        <option value="Guinea">Guinea</option>
                                                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                        <option value="Guyana">Guyana</option>
                                                        <option value="Haiti">Haiti</option>
                                                        <option value="Heard and Mc Donald Islands">Heard and Mc Donald
                                                            Islands</option>
                                                        <option value="Holy See (Vatican City State)">Holy See (Vatican
                                                            City State)</option>
                                                        <option value="Honduras">Honduras</option>
                                                        <option value="Hong Kong">Hong Kong</option>
                                                        <option value="Hungary">Hungary</option>
                                                        <option value="Iceland">Iceland</option>
                                                        <option value="India">India</option>
                                                        <option value="Indonesia">Indonesia</option>
                                                        <option value="Iran (Islamic Republic of)">Iran (Islamic
                                                            Republic of)</option>
                                                        <option value="Iraq">Iraq</option>
                                                        <option value="Ireland">Ireland</option>
                                                        <option value="Israel">Israel</option>
                                                        <option value="Italy">Italy</option>
                                                        <option value="Jamaica">Jamaica</option>
                                                        <option value="Japan">Japan</option>
                                                        <option value="Jordan">Jordan</option>
                                                        <option value="Kazakhstan">Kazakhstan</option>
                                                        <option value="Kenya">Kenya</option>
                                                        <option value="Kiribati">Kiribati</option>
                                                        <option value="Korea, Democratic People's Republic of">Korea,
                                                            Democratic People's Republic of</option>
                                                        <option value="Korea, Republic of">Korea, Republic of</option>
                                                        <option value="Kuwait">Kuwait</option>
                                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                        <option value="Lao, People's Democratic Republic">Lao, People's
                                                            Democratic Republic</option>
                                                        <option value="Latvia">Latvia</option>
                                                        <option value="Lebanon">Lebanon</option>
                                                        <option value="Lesotho">Lesotho</option>
                                                        <option value="Liberia">Liberia</option>
                                                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya
                                                        </option>
                                                        <option value="Liechtenstein">Liechtenstein</option>
                                                        <option value="Lithuania">Lithuania</option>
                                                        <option value="Luxembourg">Luxembourg</option>
                                                        <option value="Macau">Macau</option>
                                                        <option value="Macedonia, The Former Yugoslav Republic of">
                                                            Macedonia, The Former Yugoslav Republic of</option>
                                                        <option value="Madagascar">Madagascar</option>
                                                        <option value="Malawi">Malawi</option>
                                                        <option value="Malaysia">Malaysia</option>
                                                        <option value="Maldives">Maldives</option>
                                                        <option value="Mali">Mali</option>
                                                        <option value="Malta">Malta</option>
                                                        <option value="Marshall Islands">Marshall Islands</option>
                                                        <option value="Martinique">Martinique</option>
                                                        <option value="Mauritania">Mauritania</option>
                                                        <option value="Mauritius">Mauritius</option>
                                                        <option value="Mayotte">Mayotte</option>
                                                        <option value="Mexico">Mexico</option>
                                                        <option value="Micronesia, Federated States of">Micronesia,
                                                            Federated States of</option>
                                                        <option value="Moldova, Republic of">Moldova, Republic of
                                                        </option>
                                                        <option value="Monaco">Monaco</option>
                                                        <option value="Mongolia">Mongolia</option>
                                                        <option value="Montserrat">Montserrat</option>
                                                        <option value="Morocco">Morocco</option>
                                                        <option value="Mozambique">Mozambique</option>
                                                        <option value="Myanmar">Myanmar</option>
                                                        <option value="Namibia">Namibia</option>
                                                        <option value="Nauru">Nauru</option>
                                                        <option value="Nepal">Nepal</option>
                                                        <option value="Netherlands">Netherlands</option>
                                                        <option value="Netherlands Antilles">Netherlands Antilles
                                                        </option>
                                                        <option value="New Caledonia">New Caledonia</option>
                                                        <option value="New Zealand">New Zealand</option>
                                                        <option value="Nicaragua">Nicaragua</option>
                                                        <option value="Niger">Niger</option>
                                                        <option value="Nigeria">Nigeria</option>
                                                        <option value="Niue">Niue</option>
                                                        <option value="Norfolk Island">Norfolk Island</option>
                                                        <option value="Northern Mariana Islands">Northern Mariana
                                                            Islands</option>
                                                        <option value="Norway">Norway</option>
                                                        <option value="Oman">Oman</option>
                                                        <option value="Pakistan">Pakistan</option>
                                                        <option value="Palau">Palau</option>
                                                        <option value="Panama">Panama</option>
                                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                                        <option value="Paraguay">Paraguay</option>
                                                        <option value="Peru">Peru</option>
                                                        <option value="Philippines">Philippines</option>
                                                        <option value="Pitcairn">Pitcairn</option>
                                                        <option value="Poland">Poland</option>
                                                        <option value="Portugal">Portugal</option>
                                                        <option value="Puerto Rico">Puerto Rico</option>
                                                        <option value="Qatar">Qatar</option>
                                                        <option value="Reunion">Reunion</option>
                                                        <option value="Romania">Romania</option>
                                                        <option value="Russian Federation">Russian Federation</option>
                                                        <option value="Rwanda">Rwanda</option>
                                                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis
                                                        </option>
                                                        <option value="Saint Lucia">Saint Lucia</option>
                                                        <option value="Saint Vincent and the Grenadines">Saint Vincent
                                                            and the Grenadines</option>
                                                        <option value="Samoa">Samoa</option>
                                                        <option value="San Marino">San Marino</option>
                                                        <option value="Sao Tome and Principe">Sao Tome and Principe
                                                        </option>
                                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                                        <option value="Senegal">Senegal</option>
                                                        <option value="Seychelles">Seychelles</option>
                                                        <option value="Sierra Leone">Sierra Leone</option>
                                                        <option value="Singapore">Singapore</option>
                                                        <option value="Slovakia (Slovak Republic)">Slovakia (Slovak
                                                            Republic)</option>
                                                        <option value="Slovenia">Slovenia</option>
                                                        <option value="Solomon Islands">Solomon Islands</option>
                                                        <option value="Somalia">Somalia</option>
                                                        <option value="South Africa">South Africa</option>
                                                        <option value="South Georgia and the South Sandwich Islands">
                                                            South Georgia and the South Sandwich Islands</option>
                                                        <option value="Spain">Spain</option>
                                                        <option value="Sri Lanka">Sri Lanka</option>
                                                        <option value="St. Helena">St. Helena</option>
                                                        <option value="St. Pierre and Miquelon">St. Pierre and Miquelon
                                                        </option>
                                                        <option value="Sudan">Sudan</option>
                                                        <option value="Suriname">Suriname</option>
                                                        <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan
                                                            Mayen Islands</option>
                                                        <option value="Swaziland">Swaziland</option>
                                                        <option value="Sweden">Sweden</option>
                                                        <option value="Switzerland">Switzerland</option>
                                                        <option value="Syrian Arab Republic">Syrian Arab Republic
                                                        </option>
                                                        <option value="Taiwan, Province of China">Taiwan, Province of
                                                            China</option>
                                                        <option value="Tajikistan">Tajikistan</option>
                                                        <option value="Tanzania, United Republic of">Tanzania, United
                                                            Republic of</option>
                                                        <option value="Thailand">Thailand</option>
                                                        <option value="Togo">Togo</option>
                                                        <option value="Tokelau">Tokelau</option>
                                                        <option value="Tonga">Tonga</option>
                                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                        <option value="Tunisia">Tunisia</option>
                                                        <option value="Turkey">Turkey</option>
                                                        <option value="Turkmenistan">Turkmenistan</option>
                                                        <option value="Turks and Caicos Islands">Turks and Caicos
                                                            Islands</option>
                                                        <option value="Tuvalu">Tuvalu</option>
                                                        <option value="Uganda">Uganda</option>
                                                        <option value="Ukraine">Ukraine</option>
                                                        <option value="United Arab Emirates">United Arab Emirates
                                                        </option>
                                                        <option value="United Kingdom">United Kingdom</option>
                                                        <option value="United States">United States</option>
                                                        <option value="United States Minor Outlying Islands">United
                                                            States Minor Outlying Islands</option>
                                                        <option value="Uruguay">Uruguay</option>
                                                        <option value="Uzbekistan">Uzbekistan</option>
                                                        <option value="Vanuatu">Vanuatu</option>
                                                        <option value="Venezuela">Venezuela</option>
                                                        <option value="Vietnam">Vietnam</option>
                                                        <option value="Virgin Islands (British)">Virgin Islands
                                                            (British)</option>
                                                        <option value="Virgin Islands (U.S.)">Virgin Islands (U.S.)
                                                        </option>
                                                        <option value="Wallis and Futuna Islands">Wallis and Futuna
                                                            Islands</option>
                                                        <option value="Western Sahara">Western Sahara</option>
                                                        <option value="Yemen">Yemen</option>
                                                        <option value="Yugoslavia">Yugoslavia</option>
                                                        <option value="Zambia">Zambia</option>
                                                        <option value="Zimbabwe">Zimbabwe</option>
                                                    </select></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="form-wizard-progress-card-holder-zip-code">Zip
                                                        Code</label><input class="form-control" placeholder="1234"
                                                        name="zipCode" type="text"
                                                        id="form-wizard-progress-card-holder-zip-code"></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-0"><label class="form-label"
                                                        for="form-wizard-progress-card-exp-date">Exp Date</label><input
                                                        class="form-control" placeholder="15/2024" name="expDate"
                                                        type="text" id="form-wizard-progress-card-exp-date"></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-0"><label class="form-label"
                                                        for="form-wizard-progress-card-cvv">CVV</label><span
                                                        class="ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="" data-bs-original-title="Card verification value"
                                                        aria-label="Card verification value"><svg
                                                            class="svg-inline--fa fa-question-circle fa-w-16"
                                                            aria-hidden="true" focusable="false" data-prefix="fa"
                                                            data-icon="question-circle" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zM262.655 90c-54.497 0-89.255 22.957-116.549 63.758-3.536 5.286-2.353 12.415 2.715 16.258l34.699 26.31c5.205 3.947 12.621 3.008 16.665-2.122 17.864-22.658 30.113-35.797 57.303-35.797 20.429 0 45.698 13.148 45.698 32.958 0 14.976-12.363 22.667-32.534 33.976C247.128 238.528 216 254.941 216 296v4c0 6.627 5.373 12 12 12h56c6.627 0 12-5.373 12-12v-1.333c0-28.462 83.186-29.647 83.186-106.667 0-58.002-60.165-102-116.531-102zM256 338c-25.365 0-46 20.635-46 46 0 25.364 20.635 46 46 46s46-20.636 46-46c0-25.365-20.635-46-46-46z">
                                                            </path>
                                                        </svg>
                                                        <!-- <span class="fa fa-question-circle"></span> Font Awesome fontawesome.com --></span><input
                                                        class="form-control" placeholder="123" name="cvv" maxlength="3"
                                                        pattern="[0-9]{3}" type="text"
                                                        id="form-wizard-progress-card-cvv"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="form-wizard-progress-tab4" id="form-wizard-progress-tab4">
                                    <div class="wizard-lottie-wrapper">
                                        <div class="lottie wizard-lottie mx-auto my-3"
                                            data-options="{&quot;path&quot;:&quot;../../assets/img/animated-icons/celebration.json&quot;}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 464" width="264"
                                                height="464" preserveAspectRatio="xMidYMid meet"
                                                style="width: 100%; height: 100%; transform: translate3d(0px, 0px, 0px);">
                                                <defs>
                                                    <clipPath id="__lottie_element_21">
                                                        <rect width="264" height="464" x="0" y="0"></rect>
                                                    </clipPath>
                                                </defs>
                                                <g clip-path="url(#__lottie_element_21)">
                                                    <g transform="matrix(1,0,0,1,132,232)" opacity="1"
                                                        style="display: block;">
                                                        <g opacity="1" transform="matrix(1,0,0,1,0,147)">
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(203,240,248)"
                                                                                    fill-opacity="1"
                                                                                    d=" M-0.8989999890327454,80.08599853515625 C-0.7940000295639038,80.78700256347656 -0.7200000286102295,81.48899841308594 -0.6759999990463257,82.19000244140625 C-0.34200000762939453,87.56099700927734 -1.4980000257492065,93.02899932861328 -3.9690001010894775,97.80599975585938 C-5.301000118255615,100.37899780273438 -7.017000198364258,101.64800262451172 -10.517999649047852,102.7229995727539 C-11.420000076293945,105.37799835205078 -12.321000099182129,108.03399658203125 -13.111000061035156,109.33300018310547 C-13.656000137329102,110.42500305175781 -14.842000007629395,111.00900268554688 -15.972000122070312,110.91600036621094 C-17.53499984741211,110.55899810791016 -18.777999877929688,109.09200286865234 -18.628999710083008,107.28500366210938 C-18.628999710083008,107.28500366210938 -18.349000930786133,103.89600372314453 -18.349000930786133,103.89600372314453 C-20.174999237060547,103.97200012207031 -22.226999282836914,104.02999877929688 -24.260000228881836,103.86199951171875 C-25.840999603271484,103.73100280761719 -27.19700050354004,103.61900329589844 -28.760000228881836,103.26200103759766 C-28.760000228881836,103.26200103759766 -29.020999908447266,106.42500305175781 -29.020999908447266,106.42500305175781 C-29.170000076293945,108.23200225830078 -30.658000946044922,109.7020034790039 -32.23899841308594,109.57099914550781 C-33.36899948120117,109.47799682617188 -34.44200134277344,108.70700073242188 -34.79999923706055,107.54000091552734 C-35.36600112915039,106.12799835205078 -35.8390007019043,103.58699798583984 -36.31100082397461,101.0459976196289 C-37.946998596191406,100.31199645996094 -39.60300064086914,99.375 -40.85200119018555,98.06600189208984 C-42.0890007019043,96.76899719238281 -42.893001556396484,95.11699676513672 -43.507999420166016,93.45099639892578 C-45.91400146484375,86.9280014038086 -45.12699890136719,78.70800018310547 -41.91999816894531,72.60299682617188 C-38.14099884033203,65.40899658203125 -29.33300018310547,60.678001403808594 -20.74799919128418,61.38800048828125 C-15.503000259399414,61.821998596191406 -10.42300033569336,64.2509994506836 -6.7129998207092285,67.97000122070312 C-3.507999897003174,71.18299865722656 -1.5720000267028809,75.59100341796875 -0.8989999890327454,80.08599853515625z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9554970860481262,-0.29500046372413635,0.29500046372413635,0.9554970860481262,-23.62852668762207,-7.622283935546875)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M-42.0629997253418,75.07499694824219 C-42.13100051879883,72.34600067138672 -43.540000915527344,62.6150016784668 -43.31999969482422,60.858001708984375 C-43.111000061035156,59.422000885009766 -42.117000579833984,58.492000579833984 -40.979000091552734,58.04999923706055 C-39.20000076293945,57.62900161743164 -37.465999603271484,58.4900016784668 -37.04499816894531,60.26900100708008 C-37.04499816894531,60.26900100708008 -33.599998474121094,71.36100006103516 -33.599998474121094,71.36100006103516">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9371256828308105,0.3489919900894165,-0.3489919900894165,0.9371256828308105,25.352357864379883,6.894416809082031)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M-1.7050000429153442,77.16000366210938 C-0.7760000228881836,74.59300231933594 1.805999994277954,67.54199981689453 2.1540000438690186,65.80599975585938 C2.4110000133514404,64.37699890136719 1.7619999647140503,63.180999755859375 0.8230000138282776,62.4010009765625 C-0.7300000190734863,61.4379997253418 -2.6480000019073486,61.70500183105469 -3.6110000610351562,63.257999420166016 C-3.6110000610351562,63.257999420166016 -9.840999603271484,71.70099639892578 -9.840999603271484,71.70099639892578">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(1,0,0,0.7300000190734863,0,16.554397583007812)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(36,193,224)" fill-opacity="1"
                                                                            d=" M-18.285999298095703,71.75299835205078 C-18.694000244140625,71.70500183105469 -19.139999389648438,71.98400115966797 -19.187999725341797,72.39199829101562 C-19.22599983215332,72.71600341796875 -19.76300048828125,75.17500305175781 -22.716999053955078,74.87100219726562 C-25.66200065612793,74.48400115966797 -25.614999771118164,71.96800231933594 -25.57699966430664,71.64399719238281 C-25.52899932861328,71.23600006103516 -25.89900016784668,70.86199951171875 -26.30699920654297,70.81400299072266 C-26.71500015258789,70.76599884033203 -27.089000701904297,71.13600158691406 -27.136999130249023,71.54399871826172 C-27.22800064086914,73.02300262451172 -26.492000579833984,75.9219970703125 -22.899999618530273,76.34300231933594 C-22.895999908447266,76.34300231933594 -22.89299964904785,76.34400177001953 -22.888999938964844,76.34400177001953 C-22.88599967956543,76.34500122070312 -22.882999420166016,76.34600067138672 -22.878999710083008,76.34600067138672 C-19.28700065612793,76.76699829101562 -17.900999069213867,74.11499786376953 -17.64699935913086,72.65499877929688 C-17.599000930786133,72.24700164794922 -17.878000259399414,71.8010025024414 -18.285999298095703,71.75299835205078z M-16.341999053955078,65.36100006103516 C-15.125,65.50399780273438 -14.253000259399414,66.60600280761719 -14.395999908447266,67.822998046875 C-14.538999557495117,69.04000091552734 -15.642000198364258,69.91200256347656 -16.858999252319336,69.76899719238281 C-18.076000213623047,69.6259994506836 -18.94700050354004,68.52400207519531 -18.804000854492188,67.30699920654297 C-18.660999298095703,66.08999633789062 -17.55900001525879,65.21800231933594 -16.341999053955078,65.36100006103516z M-27.2810001373291,64.08000183105469 C-26.06399917602539,64.2229995727539 -25.191999435424805,65.32499694824219 -25.334999084472656,66.54199981689453 C-25.47800064086914,67.75900268554688 -26.579999923706055,68.63099670410156 -27.797000885009766,68.48799896240234 C-29.013999938964844,68.34500122070312 -29.88599967956543,67.24299621582031 -29.743000030517578,66.0260009765625 C-29.600000381469727,64.80899810791016 -28.49799919128418,63.9370002746582 -27.2810001373291,64.08000183105469z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(209,226,253)"
                                                                                    fill-opacity="1"
                                                                                    d=" M54.680999755859375,82.1780014038086 C54.84299850463867,82.86799621582031 54.97600173950195,83.56099700927734 55.07699966430664,84.25599670410156 C55.85300064086914,89.58100128173828 55.150001525878906,95.1259994506836 53.08100128173828,100.08999633789062 C51.965999603271484,102.76399993896484 50.361000061035156,104.1709976196289 46.96099853515625,105.53099822998047 C46.28099822998047,108.2509994506836 45.599998474121094,110.97100067138672 44.91999816894531,112.33100128173828 C44.46699905395508,113.46399688720703 43.33300018310547,114.1449966430664 42.20000076293945,114.1449966430664 C40.612998962402344,113.91799926757812 39.25299835205078,112.55899810791016 39.25299835205078,110.74500274658203 C39.25299835205078,110.74500274658203 39.25299835205078,107.34400177001953 39.25299835205078,107.34400177001953 C37.43899917602539,107.57099914550781 35.39899826049805,107.7979965209961 33.35900115966797,107.7979965209961 C31.77199935913086,107.7979965209961 30.41200065612793,107.7979965209961 28.825000762939453,107.57099914550781 C28.825000762939453,107.57099914550781 28.825000762939453,110.74500274658203 28.825000762939453,110.74500274658203 C28.825000762939453,112.55899810791016 27.46500015258789,114.1449966430664 25.878000259399414,114.1449966430664 C24.7450008392334,114.1449966430664 23.611000061035156,113.46399688720703 23.158000946044922,112.33100128173828 C22.47800064086914,110.97100067138672 21.797000885009766,108.47799682617188 21.117000579833984,105.98400115966797 C19.426000595092773,105.38700103759766 17.698999404907227,104.58999633789062 16.34600067138672,103.38800048828125 C15.005999565124512,102.1969985961914 14.069000244140625,100.61799621582031 13.319000244140625,99.00800323486328 C10.383999824523926,92.70500183105469 10.489999771118164,84.447998046875 13.182999610900879,78.0999984741211 C16.35700035095215,70.61900329589844 24.7450008392334,65.17900085449219 33.35900115966797,65.17900085449219 C38.62200164794922,65.17900085449219 43.88399887084961,67.18099975585938 47.88800048828125,70.58200073242188 C51.34700012207031,73.5199966430664 53.63999938964844,77.75399780273438 54.680999755859375,82.1780014038086z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9865243434906006,-0.16361452639102936,0.16361452639102936,0.9865243434906006,-13.019631385803223,3.6642608642578125)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M11.956000328063965,83.19000244140625 C11.663999557495117,80.47599792480469 9.456000328063965,70.89399719238281 9.531000137329102,69.125 C9.621000289916992,67.6760025024414 10.53499984741211,66.66899871826172 11.631999969482422,66.13400268554688 C13.369999885559082,65.56800079345703 15.170000076293945,66.28399658203125 15.736000061035156,68.02200317382812 C15.736000061035156,68.02200317382812 20.083999633789062,78.79199981689453 20.083999633789062,78.79199981689453">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9856430292129517,0.16884247958660126,-0.16884247958660126,0.9856430292129517,14.274322509765625,-7.196708679199219)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M54.70100021362305,82.08300018310547 C55.41600036621094,79.447998046875 57.40700149536133,72.20899963378906 57.611000061035156,70.44999694824219 C57.749000549316406,69.00499725341797 57.005001068115234,67.86599731445312 56.005001068115234,67.16600036621094 C54.37699890136719,66.33399963378906 52.48699951171875,66.75800323486328 51.654998779296875,68.38600158691406 C51.654998779296875,68.38600158691406 46.141998291015625,77.31300354003906 46.141998291015625,77.31300354003906">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                            d=" M29.184999465942383,74.53700256347656 C28.781999588012695,74.51599884033203 28.437999725341797,74.9020004272461 28.41699981689453,75.30500030517578 C28.42099952697754,76.76100158691406 29.323999404907227,79.55799865722656 32.87200164794922,79.74500274658203 C36.41999816894531,79.93199920654297 37.612998962402344,77.24600219726562 37.77000045776367,75.79900360107422 C37.85100173950195,75.3219985961914 37.6510009765625,74.98400115966797 37.24800109863281,74.96299743652344 C37.24800109863281,74.96299743652344 29.184999465942383,74.53700256347656 29.184999465942383,74.53700256347656z M38.86899948120117,69.66600036621094 C40.090999603271484,69.76300048828125 41.00299835205078,70.83100128173828 40.90599822998047,72.0530014038086 C40.808998107910156,73.2750015258789 39.74100112915039,74.18699645996094 38.51900100708008,74.08999633789062 C37.297000885009766,73.99299621582031 36.3849983215332,72.92500305175781 36.481998443603516,71.7030029296875 C36.57899856567383,70.48100280761719 37.64699935913086,69.56900024414062 38.86899948120117,69.66600036621094z M27.889999389648438,68.7959976196289 C29.11199951171875,68.89299774169922 30.02400016784668,69.96099853515625 29.927000045776367,71.18299865722656 C29.829999923706055,72.40499877929688 28.761999130249023,73.31700134277344 27.540000915527344,73.22000122070312 C26.31800079345703,73.12300109863281 25.4060001373291,72.05500030517578 25.503000259399414,70.83300018310547 C25.600000381469727,69.61100006103516 26.667999267578125,68.6989974975586 27.889999389648438,68.7959976196289z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(209,226,253)"
                                                                                    fill-opacity="1"
                                                                                    d=" M-55.22200012207031,79.56400299072266 C-55.09600067138672,80.26100158691406 -55,80.96199798583984 -54.93600082397461,81.66100311279297 C-54.44200134277344,87.01899719238281 -55.435001373291016,92.51899719238281 -57.76300048828125,97.36699676513672 C-59.018001556396484,99.97899627685547 -60.69499969482422,101.29900360107422 -64.16200256347656,102.47799682617188 C-64.98400115966797,105.15899658203125 -65.80699920654297,107.83999633789062 -66.55799865722656,109.16200256347656 C-67.06999969482422,110.2699966430664 -68.23799896240234,110.88899993896484 -69.37000274658203,110.8290023803711 C-70.94300079345703,110.51899719238281 -72.2300033569336,109.08899688720703 -72.13400268554688,107.27799987792969 C-72.13400268554688,107.27799987792969 -71.95500183105469,103.88300323486328 -71.95500183105469,103.88300323486328 C-73.77799987792969,104.01399993896484 -75.8270034790039,104.13300323486328 -77.86399841308594,104.0250015258789 C-79.4489974975586,103.94100189208984 -80.80699920654297,103.87000274658203 -82.37999725341797,103.55999755859375 C-82.37999725341797,103.55999755859375 -82.5469970703125,106.72899627685547 -82.5469970703125,106.72899627685547 C-82.64299774169922,108.54000091552734 -84.08399963378906,110.0530014038086 -85.66899871826172,109.96900177001953 C-86.8010025024414,109.90899658203125 -87.89700317382812,109.1709976196289 -88.29000091552734,108.01499938964844 C-88.89700317382812,106.62100219726562 -89.44499969482422,104.09500122070312 -89.99299621582031,101.56900024414062 C-91.6500015258789,100.88400268554688 -93.33399963378906,99.99800109863281 -94.62100219726562,98.72599792480469 C-95.89600372314453,97.46600341796875 -96.75,95.83899688720703 -97.41400146484375,94.19200134277344 C-100.01300048828125,87.74299621582031 -99.47100067138672,79.50299835205078 -96.4469985961914,73.30599975585938 C-92.88300323486328,66.00299835205078 -84.22100067138672,61.01100158691406 -75.61900329589844,61.46500015258789 C-70.36299896240234,61.742000579833984 -65.21399688720703,64.0199966430664 -61.39400100708008,67.62699890136719 C-58.09400177001953,70.74299621582031 -56.02899932861328,75.09100341796875 -55.22200012207031,79.56400299072266z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9811193943023682,-0.19340306520462036,0.19340306520462036,0.9811193943023682,-16.369491577148438,-16.872451782226562)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M-97.94100189208984,78.3239974975586 C-98.08999633789062,75.5979995727539 -99.79000091552734,65.91400146484375 -99.62200164794922,64.1510009765625 C-99.45600128173828,62.70899963378906 -98.48899841308594,61.750999450683594 -97.36499786376953,61.275001525878906 C-95.5999984741211,60.801998138427734 -93.83999633789062,61.611000061035156 -93.36699676513672,63.375999450683594 C-93.36699676513672,63.375999450683594 -89.59200286865234,74.36000061035156 -89.59200286865234,74.36000061035156">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9811193943023682,0.19340306520462036,-0.19340306520462036,0.9811193943023682,13.77676010131836,13.248119354248047)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M-55.196998596191406,79.47100067138672 C-54.345001220703125,76.87799835205078 -51.9739990234375,69.75299835205078 -51.678001403808594,68.00700378417969 C-51.4640007019043,66.57099914550781 -52.14699935913086,65.3949966430664 -53.10900115966797,64.64299774169922 C-54.689998626708984,63.72700119018555 -56.60100173950195,64.0510025024414 -57.516998291015625,65.63200378417969 C-57.516998291015625,65.63200378417969 -63.492000579833984,74.25599670410156 -63.492000579833984,74.25599670410156">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(1,0,0,0.75,0,15.995750427246094)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                            d=" M-80.1050033569336,63.73099899291992 C-81.23400115966797,63.55500030517578 -82.35199737548828,64.11599731445312 -82.88700103759766,65.1259994506836 C-82.9990005493164,65.33799743652344 -83.0009994506836,65.58499908447266 -82.89199829101562,65.802001953125 C-82.78199768066406,66.02200317382812 -82.57099914550781,66.17500305175781 -82.3290023803711,66.21299743652344 C-82.01499938964844,66.26200103759766 -81.70099639892578,66.1050033569336 -81.5469970703125,65.82099914550781 C-81.31099700927734,65.38600158691406 -80.82499694824219,65.1449966430664 -80.33699798583984,65.22100067138672 C-79.8489990234375,65.2969970703125 -79.45999908447266,65.67400360107422 -79.36799621582031,66.16000366210938 C-79.30699920654297,66.47699737548828 -79.05599975585938,66.7229995727539 -78.74199676513672,66.77200317382812 C-78.5,66.80999755859375 -78.25199890136719,66.72699737548828 -78.08100128173828,66.5510025024414 C-77.91100311279297,66.37699890136719 -77.83799743652344,66.14099884033203 -77.87999725341797,65.90499877929688 C-78.08200073242188,64.77999877929688 -78.97599792480469,63.90700149536133 -80.1050033569336,63.73099899291992z M-66.40899658203125,67.69200134277344 C-66.61100006103516,66.56700134277344 -67.50499725341797,65.69300079345703 -68.63400268554688,65.51699829101562 C-69.76300048828125,65.34100341796875 -70.87999725341797,65.9020004272461 -71.41500091552734,66.91200256347656 C-71.5270004272461,67.1240005493164 -71.52899932861328,67.37100219726562 -71.41999816894531,67.58799743652344 C-71.30999755859375,67.80799865722656 -71.0999984741211,67.96099853515625 -70.85800170898438,67.9990005493164 C-70.54399871826172,68.0479965209961 -70.2300033569336,67.89099884033203 -70.07599639892578,67.60700225830078 C-69.83999633789062,67.1719970703125 -69.35399627685547,66.93099975585938 -68.86599731445312,67.00700378417969 C-68.37799835205078,67.08300018310547 -67.98799896240234,67.45999908447266 -67.89600372314453,67.94599914550781 C-67.83499908447266,68.26300048828125 -67.58499908447266,68.50900268554688 -67.27100372314453,68.55799865722656 C-67.02899932861328,68.59600067138672 -66.78099822998047,68.51300048828125 -66.60900115966797,68.33699798583984 C-66.43900299072266,68.16300201416016 -66.36699676513672,67.9280014038086 -66.40899658203125,67.69200134277344z M-71.51799774169922,70.24299621582031 C-71.8489990234375,70.19200134277344 -72.15399932861328,70.41600036621094 -72.27200317382812,70.73600006103516 C-72.28199768066406,70.802001953125 -72.76399993896484,73.02899932861328 -75.2770004272461,72.63800048828125 C-77.7239990234375,72.25700378417969 -77.60299682617188,70.177001953125 -77.56199645996094,69.91200256347656 C-77.51100158691406,69.58100128173828 -77.80000305175781,69.26499938964844 -78.13099670410156,69.21399688720703 C-78.46199798583984,69.16300201416016 -78.77799987792969,69.45099639892578 -78.8290023803711,69.78199768066406 C-78.947998046875,70.98300170898438 -78.43900299072266,73.36499786376953 -75.52899932861328,73.81800079345703 C-72.61900329589844,74.27100372314453 -71.40899658203125,72.15699768066406 -71.15799713134766,70.97699737548828 C-70.9739990234375,70.66699981689453 -71.18699645996094,70.29399871826172 -71.51799774169922,70.24299621582031z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(203,240,248)"
                                                                                    fill-opacity="1"
                                                                                    d=" M106.04000091552734,74.5270004272461 C106.322998046875,75.1760025024414 106.5790023803711,75.83599853515625 106.8030014038086,76.5009994506836 C108.52200317382812,81.5999984741211 108.82599639892578,87.18099975585938 107.68199920654297,92.43599700927734 C107.06500244140625,95.26699829101562 105.73799896240234,96.93900299072266 102.63700103759766,98.88700103759766 C102.45600128173828,101.68499755859375 102.2760009765625,104.48300170898438 101.85099792480469,105.94300079345703 C101.60800170898438,107.13899993896484 100.61499786376953,108.01300048828125 99.5,108.21600341796875 C97.89800262451172,108.27799987792969 96.31700134277344,107.18399810791016 95.99099731445312,105.4000015258789 C95.99099731445312,105.4000015258789 95.37999725341797,102.05400085449219 95.37999725341797,102.05400085449219 C93.63700103759766,102.60299682617188 91.66999816894531,103.19200134277344 89.66300201416016,103.55799865722656 C88.10199737548828,103.84300231933594 86.76399993896484,104.08699798583984 85.16200256347656,104.14900207519531 C85.16200256347656,104.14900207519531 85.73200225830078,107.27100372314453 85.73200225830078,107.27100372314453 C86.05799865722656,109.05500030517578 85.00399780273438,110.86100006103516 83.44300079345703,111.14600372314453 C82.3280029296875,111.3489990234375 81.09100341796875,110.88400268554688 80.44200134277344,109.8499984741211 C79.52899932861328,108.63400268554688 78.41200256347656,106.3030014038086 77.29499816894531,103.97200012207031 C75.52400207519531,103.68800354003906 73.68099975585938,103.21499633789062 72.13500213623047,102.2750015258789 C70.60299682617188,101.34400177001953 69.39800262451172,99.95800018310547 68.37100219726562,98.50900268554688 C64.35199737548828,92.83599853515625 62.9739990234375,84.69300079345703 64.48400115966797,77.96499633789062 C66.26300048828125,70.03600311279297 73.53800201416016,63.178001403808594 82.01300048828125,61.63199996948242 C87.19100189208984,60.6870002746582 92.72599792480469,61.71200180053711 97.2760009765625,64.33899688720703 C101.20600128173828,66.60800170898438 104.22100067138672,70.36199951171875 106.04000091552734,74.5270004272461z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9526861310005188,-0.3039558231830597,0.3039558231830597,0.9526861310005188,-20.622276306152344,24.267494201660156)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M64.19000244140625,83.19300079345703 C63.415000915527344,80.57499694824219 59.52399826049805,71.5459976196289 59.279998779296875,69.79199981689453 C59.10900115966797,68.35099792480469 59.82699966430664,67.19499969482422 60.81100082397461,66.47200012207031 C62.41899871826172,65.60299682617188 64.31800079345703,65.98400115966797 65.18699645996094,67.59200286865234 C65.18699645996094,67.59200286865234 71.39700317382812,77.40699768066406 71.39700317382812,77.40699768066406">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9770575761795044,0.21297533810138702,-0.21297533810138702,0.9770575761795044,17.669960021972656,-19.77887725830078)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M106.04299926757812,74.43099975585938 C106.27300262451172,71.71099853515625 106.93199920654297,64.23100280761719 106.81700134277344,62.4640007019043 C106.69400024414062,61.018001556396484 105.75599670410156,60.03200149536133 104.64700317382812,59.52199935913086 C102.89700317382812,58.99599838256836 101.11399841308594,59.75199890136719 100.58799743652344,61.50199890136719 C100.58799743652344,61.50199890136719 96.76699829101562,71.27400207519531 96.76699829101562,71.27400207519531">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(36,193,224)" fill-opacity="1"
                                                                            d=" M85.03199768066406,68.8239974975586 C84.63999938964844,68.9469985961914 84.34600067138672,69.38400268554688 84.46900177001953,69.7760009765625 C84.56600189208984,70.08699798583984 85.08000183105469,72.5510025024414 82.25900268554688,73.47899627685547 C79.41300201416016,74.3270034790039 78.4280014038086,72.01000213623047 78.33100128173828,71.6989974975586 C78.20800018310547,71.30699920654297 77.71800231933594,71.11599731445312 77.32599639892578,71.23899841308594 C76.93399810791016,71.36199951171875 76.74299621582031,71.85199737548828 76.86599731445312,72.24400329589844 C77.38700103759766,73.63099670410156 79.24099731445312,75.97799682617188 82.69200134277344,74.89700317382812 C82.69599914550781,74.89600372314453 82.6989974975586,74.89399719238281 82.7020034790039,74.89299774169922 C82.70500183105469,74.89199829101562 82.70899963378906,74.89199829101562 82.71299743652344,74.89099884033203 C86.16400146484375,73.80999755859375 86.3479995727539,70.822998046875 85.98400115966797,69.38700103759766 C85.86100006103516,68.99500274658203 85.42400360107422,68.70099639892578 85.03199768066406,68.8239974975586z M84.61499786376953,63.027000427246094 C85.78399658203125,62.6609992980957 87.02999877929688,63.3120002746582 87.39600372314453,64.48100280761719 C87.76200103759766,65.6500015258789 87.11100006103516,66.89600372314453 85.94200134277344,67.26200103759766 C84.77300262451172,67.62799835205078 83.5270004272461,66.97699737548828 83.16100311279297,65.80799865722656 C82.79499816894531,64.63899993896484 83.44599914550781,63.393001556396484 84.61499786376953,63.027000427246094z M74.1050033569336,66.31999969482422 C75.27400207519531,65.9540023803711 76.52100372314453,66.6050033569336 76.88700103759766,67.77400207519531 C77.25299835205078,68.94300079345703 76.60099792480469,70.18900299072266 75.43199920654297,70.55500030517578 C74.26300048828125,70.9209976196289 73.01699829101562,70.2699966430664 72.6510009765625,69.10099792480469 C72.28500366210938,67.93199920654297 72.93599700927734,66.68599700927734 74.1050033569336,66.31999969482422z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g opacity="1"
                                                            transform="matrix(0.9959532618522644,0.08987294882535934,-0.08987294882535934,0.9959532618522644,1.8149309158325195,134.91146850585938)">
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(209,226,253)" fill-opacity="1"
                                                                            d=" M22.850000381469727,28.0939998626709 C22.364999771118164,28.86400032043457 21.849000930786133,29.608999252319336 21.30500030517578,30.327999114990234 C17.132999420166016,35.83599853515625 11.428000450134277,40.191001892089844 5.021999835968018,42.770999908447266 C1.5700000524520874,44.1609992980957 -1.1629999876022339,43.95899963378906 -5.4710001945495605,42.07400131225586 C-8.572999954223633,43.90299987792969 -11.673999786376953,45.731998443603516 -13.531000137329102,46.334999084472656 C-14.97599983215332,46.94200134277344 -16.621000289916992,46.518001556396484 -17.642000198364258,45.48099899291992 C-18.864999771118164,43.82500076293945 -18.844999313354492,41.35499954223633 -17.18600082397461,39.72100067138672 C-17.18600082397461,39.72100067138672 -14.076000213623047,36.65700149536133 -14.076000213623047,36.65700149536133 C-15.918000221252441,35.20199966430664 -17.964000701904297,33.540000915527344 -19.802000045776367,31.67300033569336 C-21.23200035095215,30.22100067138672 -22.457000732421875,28.976999282836914 -23.68000030517578,27.320999145507812 C-23.68000030517578,27.320999145507812 -26.58300018310547,30.180999755859375 -26.58300018310547,30.180999755859375 C-28.242000579833984,31.815000534057617 -30.920000076293945,32.000999450683594 -32.349998474121094,30.548999786376953 C-33.37099838256836,29.511999130249023 -33.77000045776367,27.86199951171875 -33.141998291015625,26.426000595092773 C-32.5099983215332,24.577999114990234 -30.840999603271484,21.708999633789062 -29.17300033569336,18.84000015258789 C-30.150999069213867,16.7549991607666 -30.979000091552734,14.456999778747559 -31.097999572753906,12.13599967956543 C-31.215999603271484,9.836999893188477 -30.615999221801758,7.556000232696533 -29.819000244140625,5.419000148773193 C-26.697999954223633,-2.946000099182129 -19.04800033569336,-10.288999557495117 -10.814000129699707,-13.545000076293945 C-1.1100000143051147,-17.382999420166016 11.425999641418457,-14.612000465393066 19.187999725341797,-6.730999946594238 C23.93000030517578,-1.9160000085830688 26.84000015258789,4.702000141143799 27.336999893188477,11.430000305175781 C27.766000747680664,17.242000579833984 25.958999633789062,23.155000686645508 22.850000381469727,28.0939998626709z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(0.6900789737701416,-0.7237340211868286,0.7237340211868286,0.6900789737701416,-4.560037612915039,-10.902591705322266)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(209,226,253)" fill-opacity="1"
                                                                            d=" M-7.302999973297119,-6.633999824523926 C-7.302999973297119,-6.633999824523926 -7.98199987411499,-21.533000946044922 -7.98199987411499,-21.533000946044922 C-7.927000045776367,-23.878999710083008 -9.803000450134277,-25.511999130249023 -12.14900016784668,-25.566999435424805 C-13.706000328063965,-25.386999130249023 -15.243000030517578,-24.55699920654297 -15.968999862670898,-22.84000015258789 C-16.812999725341797,-20.729000091552734 -18.22100067138672,-8.180000305175781 -19.023000717163086,-4.76800012588501 C-19.023000717163086,-4.76800012588501 -7.302999973297119,-6.633999824523926 -7.302999973297119,-6.633999824523926z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(0.8430547714233398,0.537827730178833,-0.537827730178833,0.8430547714233398,15.93736457824707,-8.662952423095703)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(209,226,253)" fill-opacity="1"
                                                                            d=" M22.694000244140625,16.281999588012695 C22.694000244140625,16.281999588012695 19.381999969482422,28.62700080871582 19.381999969482422,28.62700080871582 C22.832000732421875,29.24799919128418 32.314998626708984,30.990999221801758 34.5880012512207,31.055999755859375 C36.45199966430664,31.07200050354004 37.82500076293945,29.993000030517578 38.61000061035156,28.63599967956543 C39.49300003051758,26.461000442504883 38.742000579833984,24.090999603271484 36.56700134277344,23.20800018310547 C36.56700134277344,23.20800018310547 22.694000244140625,16.281999588012695 22.694000244140625,16.281999588012695">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                        d=" M-1.2269999980926514,-1.253999948501587 C-1.4980000257492065,-1.5800000429153442 -2.0429999828338623,-1.5700000524520874 -2.36899995803833,-1.2990000247955322 C-3.490000009536743,-0.25699999928474426 -5.004000186920166,2.437000036239624 -2.615999937057495,5.309999942779541 C-0.2280000001192093,8.182999610900879 2.697000026702881,7.188000202178955 3.927000045776367,6.276000022888184 C4.353000164031982,5.999000072479248 4.4710001945495605,5.6020002365112305 4.199999809265137,5.276000022888184 C4.199999809265137,5.276000022888184 -1.2269999980926514,-1.253999948501587 -1.2269999980926514,-1.253999948501587z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(25,118,210)" fill-opacity="1"
                                                                        d=" M-3.5950000286102295,0.5690000057220459 C-4.074999809265137,1.8559999465942383 -4.079999923706055,3.5480000972747803 -2.615999937057495,5.309999942779541 C-1.7510000467300415,6.349999904632568 -0.8180000185966492,6.879000186920166 0.0820000022649765,7.0920000076293945 C0.17299999296665192,6.692999839782715 0.22599999606609344,6.28000020980835 0.22599999606609344,5.853000164031982 C0.22599999606609344,3.3889999389648438 -1.3769999742507935,1.3020000457763672 -3.5950000286102295,0.5690000057220459z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(225,247,249)" fill-opacity="1"
                                                                        d=" M23.834999084472656,10.664999961853027 C23.23699951171875,10.83899974822998 22.854999542236328,11.383000373840332 22.93000030517578,12.010000228881836 C23.347999572753906,15.670000076293945 20.679000854492188,17.636999130249023 20.679000854492188,17.636999130249023 C20.040000915527344,18.038999557495117 19.944000244140625,18.823999404907227 20.34600067138672,19.46299934387207 C20.74799919128418,20.101999282836914 21.533000946044922,20.19700050354004 22.172000885009766,19.795000076293945 C22.341999053955078,19.636999130249023 26.09000015258789,16.923999786376953 25.565000534057617,11.781999588012695 C25.461000442504883,11.055999755859375 24.888999938964844,10.574000358581543 24.163000106811523,10.678000450134277 C24.034000396728516,10.607000350952148 23.934999465942383,10.63599967956543 23.834999084472656,10.664999961853027z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(255,167,38)" fill-opacity="1"
                                                                        d=" M19.1560001373291,9.093999862670898 C15.958999633789062,12.027999877929688 10.989999771118164,11.8149995803833 8.055999755859375,8.618000030517578 C5.122000217437744,5.421000003814697 5.335000038146973,0.4519999921321869 8.531999588012695,-2.4820001125335693 C11.729000091552734,-5.415999889373779 16.697999954223633,-5.203000068664551 19.631999969482422,-2.00600004196167 C22.56599998474121,1.190999984741211 22.35300064086914,6.159999847412109 19.1560001373291,9.093999862670898z M6.388999938964844,-4.816999912261963 C3.191999912261963,-1.8830000162124634 -1.7769999504089355,-2.0969998836517334 -4.710999965667725,-5.294000148773193 C-7.644999980926514,-8.491000175476074 -7.432000160217285,-13.460000038146973 -4.235000133514404,-16.393999099731445 C-1.0379999876022339,-19.327999114990234 3.930999994277954,-19.11400032043457 6.864999771118164,-15.916999816894531 C9.798999786376953,-12.720000267028809 9.586000442504883,-7.750999927520752 6.388999938964844,-4.816999912261963z M9.54699993133545,-0.1979999989271164 C9.54699993133545,-0.1979999989271164 4.315999984741211,-5.896999835968018 4.315999984741211,-5.896999835968018 C4.315999984741211,-5.896999835968018 6.343999862670898,-7.757999897003174 6.343999862670898,-7.757999897003174 C6.343999862670898,-7.757999897003174 11.574999809265137,-2.059000015258789 11.574999809265137,-2.059000015258789 C11.574999809265137,-2.059000015258789 9.54699993133545,-0.1979999989271164 9.54699993133545,-0.1979999989271164z M23.389999389648438,3.885999917984009 C23.389999389648438,4.690999984741211 22.73699951171875,5.343999862670898 21.93199920654297,5.343999862670898 C21.12700080871582,5.343999862670898 20.474000930786133,4.690999984741211 20.474000930786133,3.885999917984009 C20.474000930786133,3.0810000896453857 21.12700080871582,2.427999973297119 21.93199920654297,2.427999973297119 C22.73699951171875,2.427999973297119 23.389999389648438,3.0810000896453857 23.389999389648438,3.885999917984009z M2.13100004196167,-18.613000869750977 C2.13100004196167,-17.808000564575195 1.4780000448226929,-17.15399932861328 0.6729999780654907,-17.15399932861328 C-0.13199999928474426,-17.15399932861328 -0.7860000133514404,-17.808000564575195 -0.7860000133514404,-18.613000869750977 C-0.7860000133514404,-19.417999267578125 -0.13199999928474426,-20.070999145507812 0.6729999780654907,-20.070999145507812 C1.4780000448226929,-20.070999145507812 2.13100004196167,-19.417999267578125 2.13100004196167,-18.613000869750977z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                        d=" M17.871000289916992,7.693999767303467 C15.446999549865723,9.918000221252441 11.680000305175781,9.756999969482422 9.456000328063965,7.333000183105469 C7.23199987411499,4.908999919891357 7.392000198364258,1.1410000324249268 9.815999984741211,-1.0829999446868896 C12.239999771118164,-3.306999921798706 16.007999420166016,-3.1459999084472656 18.23200035095215,-0.722000002861023 C20.45599937438965,1.7020000219345093 20.295000076293945,5.46999979019165 17.871000289916992,7.693999767303467z M5.104000091552734,-6.2170000076293945 C2.680000066757202,-3.993000030517578 -1.0870000123977661,-4.1539998054504395 -3.311000108718872,-6.578000068664551 C-5.534999847412109,-9.001999855041504 -5.374000072479248,-12.770000457763672 -2.950000047683716,-14.994000434875488 C-0.5260000228881836,-17.218000411987305 3.240999937057495,-17.05699920654297 5.465000152587891,-14.633000373840332 C7.689000129699707,-12.208999633789062 7.5279998779296875,-8.440999984741211 5.104000091552734,-6.2170000076293945z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="0.3" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(255,255,255)" fill-opacity="1"
                                                                        d=" M-4.666999816894531,-9.097999572753906 C-4.427999973297119,-8.194000244140625 -4,-7.328000068664551 -3.3239998817443848,-6.591000080108643 C-2.74399995803833,-5.959000110626221 -2.053999900817871,-5.488999843597412 -1.315000057220459,-5.166999816894531 C-1.315000057220459,-5.166999816894531 6.163000106811523,-7.5920000076293945 6.163000106811523,-7.5920000076293945 C7.125999927520752,-9.21500015258789 7.263000011444092,-11.190999984741211 6.534999847412109,-12.920999526977539 C6.534999847412109,-12.920999526977539 -4.666999816894531,-9.097999572753906 -4.666999816894531,-9.097999572753906z M8.112000465393066,4.826000213623047 C8.35099983215332,5.730000019073486 8.779999732971191,6.5960001945495605 9.456000328063965,7.333000183105469 C10.03600025177002,7.965000152587891 10.725000381469727,8.435999870300293 11.46399974822998,8.758000373840332 C11.46399974822998,8.758000373840332 18.941999435424805,6.333000183105469 18.941999435424805,6.333000183105469 C19.905000686645508,4.710000038146973 20.04199981689453,2.7339999675750732 19.31399917602539,1.003999948501587 C19.31399917602539,1.003999948501587 8.112000465393066,4.826000213623047 8.112000465393066,4.826000213623047z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                            <g opacity="1"
                                                                transform="matrix(0.742929995059967,0.669369101524353,-0.669369101524353,0.742929995059967,22.954883575439453,-43.157440185546875)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(203,240,248)" fill-opacity="1"
                                                                            d=" M46.28300094604492,-9.434000015258789 C46.28300094604492,-9.434000015258789 29.57900047302246,-8.812999725341797 29.57900047302246,-8.812999725341797 C29.1560001373291,-8.79699993133545 28.878000259399414,-8.366999626159668 29.03700065612793,-7.974999904632568 C29.03700065612793,-7.974999904632568 30.96500015258789,-3.2279999256134033 30.96500015258789,-3.2279999256134033 C30.96500015258789,-3.2279999256134033 31.507999420166016,-1.8919999599456787 31.507999420166016,-1.8919999599456787 C31.507999420166016,-1.8919999599456787 33.43600082397461,2.8519999980926514 33.43600082397461,2.8519999980926514 C33.59600067138672,3.244999885559082 34.095001220703125,3.359999895095825 34.409000396728516,3.075000047683716 C36.5880012512207,1.093999981880188 43.7140007019043,-5.385000228881836 46.79399871826172,-8.190999984741211 C47.2869987487793,-8.640999794006348 46.95000076293945,-9.458999633789062 46.28300094604492,-9.434000015258789z">
                                                                        </path>
                                                                    </g>
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(148,219,224)" fill-opacity="1"
                                                                            d=" M30.836999893188477,-3.5429999828338623 C30.836999893188477,-3.5429999828338623 38.24700164794922,-0.41499999165534973 38.24700164794922,-0.41499999165534973 C39.04600143432617,-1.1410000324249268 39.895999908447266,-1.9140000343322754 40.75199890136719,-2.693000078201294 C40.75199890136719,-2.693000078201294 29.20199966430664,-7.570000171661377 29.20199966430664,-7.570000171661377 C29.20199966430664,-7.570000171661377 30.836999893188477,-3.5429999828338623 30.836999893188477,-3.5429999828338623z">
                                                                        </path>
                                                                    </g>
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(148,219,224)" fill-opacity="1"
                                                                            d=" M34.09600067138672,-8.980999946594238 C34.09600067138672,-8.980999946594238 43.36399841308594,-5.067999839782715 43.36399841308594,-5.067999839782715 C44.27899932861328,-5.901000022888184 45.13399887084961,-6.678999900817871 45.86800003051758,-7.3470001220703125 C45.86800003051758,-7.3470001220703125 41.356998443603516,-9.25100040435791 41.356998443603516,-9.25100040435791 C41.356998443603516,-9.25100040435791 34.09600067138672,-8.980999946594238 34.09600067138672,-8.980999946594238z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(148,219,224)" fill-opacity="1"
                                                                        d=" M50.084999084472656,-9.02400016784668 C49.917999267578125,-7.9670000076293945 48.92499923706055,-7.245999813079834 47.86800003051758,-7.413000106811523 C46.81100082397461,-7.579999923706055 46.09000015258789,-8.572999954223633 46.25699996948242,-9.630000114440918 C46.42399978637695,-10.687000274658203 47.41699981689453,-11.407999992370605 48.4739990234375,-11.241000175476074 C49.53099822998047,-11.074000358581543 50.25199890136719,-10.081000328063965 50.084999084472656,-9.02400016784668z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g opacity="1" transform="matrix(1,0,0,1,0,147)">
                                                            <g opacity="1"
                                                                transform="matrix(-0.32781192660331726,0.9447430372238159,-0.9447430372238159,-0.32781192660331726,79.91026306152344,-3.9100875854492188)">
                                                                <path fill="rgb(246,102,56)" fill-opacity="1"
                                                                    d=" M62.60100173950195,18.645999908447266 C60.78099822998047,23.586000442504883 56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 C56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 C56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 C56.1879997253418,24.972999572753906 60.867000579833984,26.358999252319336 62.513999938964844,31.298999786376953 C64.33399963378906,26.358999252319336 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.927001953125,24.972999572753906 64.24800109863281,23.586000442504883 62.60100173950195,18.645999908447266">
                                                                </path>
                                                            </g>
                                                            <g opacity="0.06124400000009729"
                                                                transform="matrix(0.8502083420753479,0.31218934059143066,-0.31218934059143066,0.8502083420753479,7.525489807128906,25.597789764404297)">
                                                                <path fill="rgb(253,202,64)" fill-opacity="1"
                                                                    d=" M-61.39899826049805,42.3129997253418 C-63.21900177001953,47.25299835205078 -67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 C-67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 C-67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 C-67.81199645996094,48.638999938964844 -63.132999420166016,50.0260009765625 -61.486000061035156,54.965999603271484 C-59.66600036621094,50.0260009765625 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.073001861572266,48.638999938964844 -59.75199890136719,47.25299835205078 -61.39899826049805,42.3129997253418">
                                                                </path>
                                                            </g>
                                                            <g opacity="1"
                                                                transform="matrix(0.5102083683013916,-0.8600508570671082,0.8600508570671082,0.5102083683013916,41.38810729980469,10.00941276550293)">
                                                                <path fill="rgb(253,202,64)" fill-opacity="1"
                                                                    d=" M29.243999481201172,-37.02000045776367 C27.90399932861328,-33.38199996948242 24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 C24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 C24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 C24.520999908447266,-32.36000061035156 27.966999053955078,-31.339000701904297 29.18000030517578,-27.701000213623047 C30.520000457763672,-31.339000701904297 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.90399932861328,-32.36000061035156 30.457000732421875,-33.38199996948242 29.243999481201172,-37.02000045776367">
                                                                </path>
                                                            </g>
                                                            <g opacity="0"
                                                                transform="matrix(0.801201343536377,0.5983948707580566,-0.5983948707580566,0.801201343536377,-12.011821746826172,32.30485153198242)">
                                                                <path fill="rgb(246,102,56)" fill-opacity="1"
                                                                    d=" M-54.15999984741211,-6.0269999504089355 C-55.42100143432617,-2.6040000915527344 -58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 C-58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 C-58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 C-58.604000091552734,-1.6430000066757202 -55.361000061035156,-0.6819999814033508 -54.220001220703125,2.740999937057495 C-52.95899963378906,-0.6819999814033508 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.775001525878906,-1.6430000066757202 -53.01900100708008,-2.6040000915527344 -54.15999984741211,-6.0269999504089355">
                                                                </path>
                                                            </g>
                                                            <g opacity="0"
                                                                transform="matrix(0.8221547603607178,-0.7990564703941345,0.7990564703941345,0.8221547603607178,-8.32721996307373,1.6261100769042969)">
                                                                <path fill="rgb(255,255,255)" fill-opacity="1"
                                                                    d=" M-42.262001037597656,-30.163000106811523 C-41.54399871826172,-29.516000747680664 -41.487998962402344,-28.409000396728516 -42.1349983215332,-27.69099998474121 C-42.78200149536133,-26.972999572753906 -43.88800048828125,-26.91699981689453 -44.60599899291992,-27.56399917602539 M47.02899932861328,50.5369987487793 C48.38600158691406,49.99800109863281 49.92499923706055,50.6609992980957 50.4640007019043,52.018001556396484 C51.00299835205078,53.375 50.34000015258789,54.91299819946289 48.983001708984375,55.45199966430664">
                                                                </path>
                                                                <path fill="rgb(255,213,79)" fill-opacity="1"
                                                                    d=" M47.02899932861328,50.5369987487793 C48.38600158691406,49.99800109863281 49.92499923706055,50.6609992980957 50.4640007019043,52.018001556396484 C51.00299835205078,53.375 50.34000015258789,54.91299819946289 48.983001708984375,55.45199966430664">
                                                                </path>
                                                            </g>
                                                            <g opacity="0"
                                                                transform="matrix(0.9705996513366699,0.20851095020771027,-0.20851095020771027,0.9705996513366699,0,0)">
                                                                <path fill="rgb(255,213,79)" fill-opacity="1"
                                                                    d=" M73.93099975585938,-6.883999824523926 C74.88200378417969,-6.291999816894531 75.1719970703125,-5.040999889373779 74.58000183105469,-4.090000152587891 C73.98799896240234,-3.1389999389648438 72.73699951171875,-2.8480000495910645 71.78600311279297,-3.440000057220459">
                                                                </path>
                                                            </g>
                                                            <g opacity="1"
                                                                transform="matrix(1,0,0,1,-5.514625549316406,-12.798246383666992)">
                                                                <path fill="rgb(255,213,79)" fill-opacity="1"
                                                                    d=" M69.44400024414062,41.17900085449219 C69.44400024414062,42.18000030517578 68.63200378417969,42.992000579833984 67.63099670410156,42.992000579833984 C66.62999725341797,42.992000579833984 65.81800079345703,42.18000030517578 65.81800079345703,41.17900085449219 C65.81800079345703,40.178001403808594 66.62999725341797,39.36600112915039 67.63099670410156,39.36600112915039 C68.63200378417969,39.36600112915039 69.44400024414062,40.178001403808594 69.44400024414062,41.17900085449219z">
                                                                </path>
                                                            </g>
                                                            <g opacity="1"
                                                                transform="matrix(1,0,0,1,-11.200416564941406,-37.263267517089844)">
                                                                <path fill="rgb(245,245,245)" fill-opacity="1"
                                                                    d=" M-53.305999755859375,27.448999404907227 C-53.305999755859375,28.450000762939453 -54.11800003051758,29.261999130249023 -55.11899948120117,29.261999130249023 C-56.119998931884766,29.261999130249023 -56.93199920654297,28.450000762939453 -56.93199920654297,27.448999404907227 C-56.93199920654297,26.447999954223633 -56.119998931884766,25.63599967956543 -55.11899948120117,25.63599967956543 C-54.11800003051758,25.63599967956543 -53.305999755859375,26.447999954223633 -53.305999755859375,27.448999404907227z">
                                                                </path>
                                                            </g>
                                                            <g opacity="1"
                                                                transform="matrix(0.8914922475814819,-0.4467565417289734,0.4467565417289734,0.8914922475814819,-2.096356153488159,0.10323190689086914)">
                                                                <path fill="rgb(52,168,83)" fill-opacity="1"
                                                                    d=" M-53.867000579833984,-20.260000228881836 C-53.867000579833984,-19.259000778198242 -54.67900085449219,-18.445999145507812 -55.68000030517578,-18.445999145507812 C-56.680999755859375,-18.445999145507812 -57.49300003051758,-19.259000778198242 -57.49300003051758,-20.260000228881836 C-57.49300003051758,-21.26099967956543 -56.680999755859375,-22.072999954223633 -55.68000030517578,-22.072999954223633 C-54.67900085449219,-22.072999954223633 -53.867000579833984,-21.26099967956543 -53.867000579833984,-20.260000228881836z M53.694000244140625,-25.40399932861328 C53.694000244140625,-24.402999877929688 52.88199996948242,-23.590999603271484 51.88100051879883,-23.590999603271484 C50.880001068115234,-23.590999603271484 50.06800079345703,-24.402999877929688 50.06800079345703,-25.40399932861328 C50.06800079345703,-26.405000686645508 50.880001068115234,-27.216999053955078 51.88100051879883,-27.216999053955078 C52.88199996948242,-27.216999053955078 53.694000244140625,-26.405000686645508 53.694000244140625,-25.40399932861328z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg></div>
                                    </div>
                                    <h4 class="mb-1">Your account is all set!</h4>
                                    <p>Now you can access to your account</p><a class="btn btn-primary px-5 my-3"
                                        href="../../modules/forms/wizard.html">Start Over</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="px-sm-3 px-md-5">
                                <ul class="pager wizard list-inline mb-0">
                                    <li class="previous"><button class="btn btn-link ps-0 d-none" type="button"><svg
                                                class="svg-inline--fa fa-chevron-left fa-w-10 me-2"
                                                data-fa-transform="shrink-3" aria-hidden="true" focusable="false"
                                                data-prefix="fas" data-icon="chevron-left" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;">
                                                <g transform="translate(160 256)">
                                                    <g
                                                        transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                        <path fill="currentColor"
                                                            d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"
                                                            transform="translate(-160 -256)"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <!-- <span class="fas fa-chevron-left me-2" data-fa-transform="shrink-3"></span> Font Awesome fontawesome.com -->Prev</button>
                                    </li>
                                    <li class="next"><button class="btn btn-primary px-5 px-sm-6" type="submit">Next<svg
                                                class="svg-inline--fa fa-chevron-right fa-w-10 ms-2"
                                                data-fa-transform="shrink-3" aria-hidden="true" focusable="false"
                                                data-prefix="fas" data-icon="chevron-right" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;">
                                                <g transform="translate(160 256)">
                                                    <g
                                                        transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                        <path fill="currentColor"
                                                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"
                                                            transform="translate(-160 -256)"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <!-- <span class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3"> </span> Font Awesome fontawesome.com --></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-12 col-xxl-6 h-100">
                    <div class="d-flex mb-4"><span class="fa-stack me-2 ms-n1"><svg
                                class="svg-inline--fa fa-circle fa-w-16 fa-stack-2x text-300" aria-hidden="true"
                                focusable="false" data-prefix="fas" data-icon="circle" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                            </svg>
                            <!-- <i class="fas fa-circle fa-stack-2x text-300"></i> Font Awesome fontawesome.com --><svg
                                class="svg-inline--fa fa-capsules fa-w-18 fa-inverse fa-stack-1x text-primary"
                                aria-hidden="true" focusable="false" data-prefix="fas" data-icon="capsules" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M555.3 300.1L424.2 112.8C401.9 81 366.4 64 330.4 64c-22.6 0-45.5 6.7-65.5 20.7-19.7 13.8-33.7 32.8-41.5 53.8C220.5 79.2 172 32 112 32 50.1 32 0 82.1 0 144v224c0 61.9 50.1 112 112 112s112-50.1 112-112V218.9c3.3 8.6 7.3 17.1 12.8 25L368 431.2c22.2 31.8 57.7 48.8 93.8 48.8 22.7 0 45.5-6.7 65.5-20.7 51.7-36.2 64.2-107.5 28-159.2zM160 256H64V144c0-26.5 21.5-48 48-48s48 21.5 48 48v112zm194.8 44.9l-65.6-93.7c-7.7-11-10.7-24.4-8.3-37.6 2.3-13.2 9.7-24.8 20.7-32.5 8.5-6 18.5-9.1 28.8-9.1 16.5 0 31.9 8 41.3 21.5l65.6 93.7-82.5 57.7z">
                                </path>
                            </svg>
                            <!-- <i class="fa-inverse fa-stack-1x text-primary fas fa-capsules"></i> Font Awesome fontawesome.com --></span>
                        <div class="col">
                            <h5 class="mb-0 text-primary position-relative"><span class="bg-200 dark__bg-1100 pe-3">Pill
                                    tab</span><span
                                    class="border position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                            </h5>
                            <p class="mb-0">You can easily show your stats content by using these cards.</p>
                        </div>
                    </div>
                    <div class="card theme-wizard mb-5">
                        <div class="card-header bg-light pt-3 pb-2">
                            <ul class="nav nav-pills mb-3" role="tablist" id="pill-tab1">
                                <li class="nav-item" role="presentation"><button class="nav-link active"
                                        data-wizard-step="data-wizard-step" data-bs-toggle="pill"
                                        data-bs-target="#form-wizard-tab1" type="button" role="tab"
                                        aria-controls="form-wizard-tab1" aria-selected="true"><svg
                                            class="svg-inline--fa fa-lock fa-w-14 me-2" data-fa-transform="shrink-2"
                                            aria-hidden="true" focusable="false" data-prefix="fas" data-icon="lock"
                                            role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                            data-fa-i2svg="" style="transform-origin: 0.4375em 0.5em;">
                                            <g transform="translate(224 256)">
                                                <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                    <path fill="currentColor"
                                                        d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"
                                                        transform="translate(-224 -256)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        <!-- <span class="fas fa-lock me-2" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com --><span
                                            class="d-none d-md-inline-block fs--1">Account</span></button></li>
                                <li class="nav-item" role="presentation"><button class="nav-link"
                                        data-wizard-step="data-wizard-step" data-bs-toggle="pill"
                                        data-bs-target="#form-wizard-tab2" type="button" role="tab"
                                        aria-controls="form-wizard-tab2" aria-selected="false"><svg
                                            class="svg-inline--fa fa-user fa-w-14 me-2" data-fa-transform="shrink-2"
                                            aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user"
                                            role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                            data-fa-i2svg="" style="transform-origin: 0.4375em 0.5em;">
                                            <g transform="translate(224 256)">
                                                <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                    <path fill="currentColor"
                                                        d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"
                                                        transform="translate(-224 -256)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        <!-- <span class="fas fa-user me-2" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com --><span
                                            class="d-none d-md-inline-block fs--1">Personal</span></button></li>
                                <li class="nav-item" role="presentation"><button class="nav-link"
                                        data-wizard-step="data-wizard-step" data-bs-toggle="pill"
                                        data-bs-target="#form-wizard-tab3" type="button" role="tab"
                                        aria-controls="form-wizard-tab3" aria-selected="false"><svg
                                            class="svg-inline--fa fa-dollar-sign fa-w-9 me-2"
                                            data-fa-transform="down-2 shrink-2" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="dollar-sign" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 288 512" data-fa-i2svg=""
                                            style="transform-origin: 0.28125em 0.625em;">
                                            <g transform="translate(144 256)">
                                                <g transform="translate(0, 64)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                    <path fill="currentColor"
                                                        d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z"
                                                        transform="translate(-144 -256)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        <!-- <span class="fas fa-dollar-sign me-2" data-fa-transform="down-2 shrink-2"></span> Font Awesome fontawesome.com --><span
                                            class="d-none d-md-inline-block fs--1">Billing</span></button></li>
                                <li class="nav-item" role="presentation"><button class="nav-link"
                                        data-wizard-step="data-wizard-step" data-bs-toggle="pill"
                                        data-bs-target="#form-wizard-tab4" type="button" role="tab"
                                        aria-controls="form-wizard-tab4" aria-selected="false"><svg
                                            class="svg-inline--fa fa-thumbs-up fa-w-16 me-2"
                                            data-fa-transform="shrink-2" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="thumbs-up" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                            style="transform-origin: 0.5em 0.5em;">
                                            <g transform="translate(256 256)">
                                                <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                    <path fill="currentColor"
                                                        d="M104 224H24c-13.255 0-24 10.745-24 24v240c0 13.255 10.745 24 24 24h80c13.255 0 24-10.745 24-24V248c0-13.255-10.745-24-24-24zM64 472c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zM384 81.452c0 42.416-25.97 66.208-33.277 94.548h101.723c33.397 0 59.397 27.746 59.553 58.098.084 17.938-7.546 37.249-19.439 49.197l-.11.11c9.836 23.337 8.237 56.037-9.308 79.469 8.681 25.895-.069 57.704-16.382 74.757 4.298 17.598 2.244 32.575-6.148 44.632C440.202 511.587 389.616 512 346.839 512l-2.845-.001c-48.287-.017-87.806-17.598-119.56-31.725-15.957-7.099-36.821-15.887-52.651-16.178-6.54-.12-11.783-5.457-11.783-11.998v-213.77c0-3.2 1.282-6.271 3.558-8.521 39.614-39.144 56.648-80.587 89.117-113.111 14.804-14.832 20.188-37.236 25.393-58.902C282.515 39.293 291.817 0 312 0c24 0 72 8 72 81.452z"
                                                        transform="translate(-256 -256)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        <!-- <span class="fas fa-thumbs-up me-2" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com --><span
                                            class="d-none d-md-inline-block fs--1">Done</span></button></li>
                            </ul>
                        </div>
                        <div class="card-body py-4">
                            <div class="tab-content">
                                <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="form-wizard-tab1" id="form-wizard-tab1">
                                    <form novalidate="novalidate">
                                        <div class="mb-3"><label class="form-label"
                                                for="form-wizard-wizard-name">Name</label><input class="form-control"
                                                type="text" name="name" placeholder="John Smith"
                                                id="form-wizard-wizard-name"></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="form-wizard-wizard-email">Email*</label><input class="form-control"
                                                type="email" name="email" placeholder="Email address"
                                                pattern="^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$"
                                                required="required" id="form-wizard-wizard-email"
                                                data-wizard-validate-email="true">
                                            <div class="invalid-feedback">You must add email</div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="form-wizard-wizard-password">Password*</label><input
                                                        class="form-control" type="password" name="password"
                                                        placeholder="Password" required="required"
                                                        id="form-wizard-wizard-password"
                                                        data-wizard-validate-password="true">
                                                    <div class="invalid-feedback">Please enter password</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="form-wizard-wizard-confirm-password">Confirm
                                                        Password*</label><input class="form-control" type="password"
                                                        name="confirmPassword" placeholder="Confirm Password"
                                                        required="required" id="form-wizard-wizard-confirm-password"
                                                        data-wizard-validate-confirm-password="true">
                                                    <div class="invalid-feedback">Passwords need to match</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox"
                                                name="terms" required="required" checked="checked"
                                                id="form-wizard-wizard-checkbox"><label class="form-check-label"
                                                for="form-wizard-wizard-checkbox">I accept the <a href="#!">terms
                                                </a>and <a href="#!">privacy policy</a></label></div>
                                    </form>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="form-wizard-tab2"
                                    id="form-wizard-tab2">
                                    <form>
                                        <div class="mb-3">
                                            <div class="row dz-clickable" data-dropzone="data-dropzone"
                                                data-options="{&quot;maxFiles&quot;:1,&quot;data&quot;:[{&quot;name&quot;:&quot;avatar.png&quot;,&quot;size&quot;:&quot;54kb&quot;,&quot;url&quot;:&quot;../../assets/img/team&quot;}]}">

                                                <div class="col-md-auto">
                                                    <div class="dz-preview dz-preview-single">
                                                        <div
                                                            class="dz-preview-cover d-flex align-items-center justify-content-center mb-3 mb-md-0 dz-image-preview">
                                                            <div class="avatar avatar-4xl"><img class="rounded-circle"
                                                                    src="../../assets/img/team/avatar.png"
                                                                    alt="avatar.png"
                                                                    data-dz-thumbnail="data-dz-thumbnail"></div>
                                                            <div class="dz-progress"><span class="dz-upload"
                                                                    data-dz-uploadprogress=""></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <div class="dz-message dropzone-area px-2 py-3"
                                                        data-dz-message="data-dz-message">
                                                        <div class="text-center"><img class="me-2"
                                                                src="../../assets/img/icons/cloud-upload.svg" width="25"
                                                                alt="">Upload your profile picture<p
                                                                class="mb-0 fs--1 text-400">Upload a 300x300 jpg image
                                                                with <br>a maximum size of 400KB</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3"><label class="form-label"
                                                for="form-wizard-gender">Gender</label><select class="form-select"
                                                name="gender" id="form-wizard-gender">
                                                <option value="">Select your gender ...</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="form-wizard-wizard-phone">Phone</label><input class="form-control"
                                                type="text" name="phone" placeholder="Phone"
                                                id="form-wizard-wizard-phone"></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="form-wizard-wizard-datepicker">Date of Birth</label><input
                                                class="form-control datetimepicker flatpickr-input" type="text"
                                                placeholder="d/m/y"
                                                data-options="{&quot;dateFormat&quot;:&quot;d/m/y&quot;,&quot;disableMobile&quot;:true}"
                                                id="form-wizard-wizard-datepicker" readonly="readonly"></div>
                                        <div class="mb-3"><label class="form-label"
                                                for="form-wizard-wizard-address">Address</label><textarea
                                                class="form-control" rows="4"
                                                id="form-wizard-wizard-address"></textarea></div>
                                    </form>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="form-wizard-tab3"
                                    id="form-wizard-tab3">
                                    <form class="form-validation">
                                        <div class="row g-2">
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label"
                                                        for="form-wizard-card-number">Card Number</label><input
                                                        class="form-control" placeholder="XXXX XXXX XXXX XXXX"
                                                        type="text" id="form-wizard-card-number"></div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label"
                                                        for="form-wizard-card-name">Name on Card</label><input
                                                        class="form-control" placeholder="John Doe" name="cardName"
                                                        type="text" id="form-wizard-card-name"></div>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="form-wizard-card-holder-country">Country</label><select
                                                        class="form-select" name="customSelectCountry"
                                                        id="form-wizard-card-holder-country">
                                                        <option value="">Select your country ...</option>
                                                        <option value="Afghanistan">Afghanistan</option>
                                                        <option value="Albania">Albania</option>
                                                        <option value="Algeria">Algeria</option>
                                                        <option value="American Samoa">American Samoa</option>
                                                        <option value="Andorra">Andorra</option>
                                                        <option value="Angola">Angola</option>
                                                        <option value="Anguilla">Anguilla</option>
                                                        <option value="Antarctica">Antarctica</option>
                                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                        <option value="Argentina">Argentina</option>
                                                        <option value="Armenia">Armenia</option>
                                                        <option value="Aruba">Aruba</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Austria">Austria</option>
                                                        <option value="Azerbaijan">Azerbaijan</option>
                                                        <option value="Bahamas">Bahamas</option>
                                                        <option value="Bahrain">Bahrain</option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                        <option value="Barbados">Barbados</option>
                                                        <option value="Belarus">Belarus</option>
                                                        <option value="Belgium">Belgium</option>
                                                        <option value="Belize">Belize</option>
                                                        <option value="Benin">Benin</option>
                                                        <option value="Bermuda">Bermuda</option>
                                                        <option value="Bhutan">Bhutan</option>
                                                        <option value="Bolivia">Bolivia</option>
                                                        <option value="Bosnia and Herzegowina">Bosnia and Herzegowina
                                                        </option>
                                                        <option value="Botswana">Botswana</option>
                                                        <option value="Bouvet Island">Bouvet Island</option>
                                                        <option value="Brazil">Brazil</option>
                                                        <option value="British Indian Ocean Territory">British Indian
                                                            Ocean Territory</option>
                                                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                        <option value="Bulgaria">Bulgaria</option>
                                                        <option value="Burkina Faso">Burkina Faso</option>
                                                        <option value="Burundi">Burundi</option>
                                                        <option value="Cambodia">Cambodia</option>
                                                        <option value="Cameroon">Cameroon</option>
                                                        <option value="Canada">Canada</option>
                                                        <option value="Cape Verde">Cape Verde</option>
                                                        <option value="Cayman Islands">Cayman Islands</option>
                                                        <option value="Central African Republic">Central African
                                                            Republic</option>
                                                        <option value="Chad">Chad</option>
                                                        <option value="Chile">Chile</option>
                                                        <option value="China">China</option>
                                                        <option value="Christmas Island">Christmas Island</option>
                                                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands
                                                        </option>
                                                        <option value="Colombia">Colombia</option>
                                                        <option value="Comoros">Comoros</option>
                                                        <option value="Congo">Congo</option>
                                                        <option value="Congo, the Democratic Republic of the">Congo, the
                                                            Democratic Republic of the</option>
                                                        <option value="Cook Islands">Cook Islands</option>
                                                        <option value="Costa Rica">Costa Rica</option>
                                                        <option value="Cote d'Ivoire">Cote d'Ivoire</option>
                                                        <option value="Croatia (Hrvatska)">Croatia (Hrvatska)</option>
                                                        <option value="Cuba">Cuba</option>
                                                        <option value="Cyprus">Cyprus</option>
                                                        <option value="Czech Republic">Czech Republic</option>
                                                        <option value="Denmark">Denmark</option>
                                                        <option value="Djibouti">Djibouti</option>
                                                        <option value="Dominica">Dominica</option>
                                                        <option value="Dominican Republic">Dominican Republic</option>
                                                        <option value="East Timor">East Timor</option>
                                                        <option value="Ecuador">Ecuador</option>
                                                        <option value="Egypt">Egypt</option>
                                                        <option value="El Salvador">El Salvador</option>
                                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                        <option value="Eritrea">Eritrea</option>
                                                        <option value="Estonia">Estonia</option>
                                                        <option value="Ethiopia">Ethiopia</option>
                                                        <option value="Falkland Islands (Malvinas)">Falkland Islands
                                                            (Malvinas)</option>
                                                        <option value="Faroe Islands">Faroe Islands</option>
                                                        <option value="Fiji">Fiji</option>
                                                        <option value="Finland">Finland</option>
                                                        <option value="France">France</option>
                                                        <option value="France Metropolitan">France Metropolitan</option>
                                                        <option value="French Guiana">French Guiana</option>
                                                        <option value="French Polynesia">French Polynesia</option>
                                                        <option value="French Southern Territories">French Southern
                                                            Territories</option>
                                                        <option value="Gabon">Gabon</option>
                                                        <option value="Gambia">Gambia</option>
                                                        <option value="Georgia">Georgia</option>
                                                        <option value="Germany">Germany</option>
                                                        <option value="Ghana">Ghana</option>
                                                        <option value="Gibraltar">Gibraltar</option>
                                                        <option value="Greece">Greece</option>
                                                        <option value="Greenland">Greenland</option>
                                                        <option value="Grenada">Grenada</option>
                                                        <option value="Guadeloupe">Guadeloupe</option>
                                                        <option value="Guam">Guam</option>
                                                        <option value="Guatemala">Guatemala</option>
                                                        <option value="Guinea">Guinea</option>
                                                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                        <option value="Guyana">Guyana</option>
                                                        <option value="Haiti">Haiti</option>
                                                        <option value="Heard and Mc Donald Islands">Heard and Mc Donald
                                                            Islands</option>
                                                        <option value="Holy See (Vatican City State)">Holy See (Vatican
                                                            City State)</option>
                                                        <option value="Honduras">Honduras</option>
                                                        <option value="Hong Kong">Hong Kong</option>
                                                        <option value="Hungary">Hungary</option>
                                                        <option value="Iceland">Iceland</option>
                                                        <option value="India">India</option>
                                                        <option value="Indonesia">Indonesia</option>
                                                        <option value="Iran (Islamic Republic of)">Iran (Islamic
                                                            Republic of)</option>
                                                        <option value="Iraq">Iraq</option>
                                                        <option value="Ireland">Ireland</option>
                                                        <option value="Israel">Israel</option>
                                                        <option value="Italy">Italy</option>
                                                        <option value="Jamaica">Jamaica</option>
                                                        <option value="Japan">Japan</option>
                                                        <option value="Jordan">Jordan</option>
                                                        <option value="Kazakhstan">Kazakhstan</option>
                                                        <option value="Kenya">Kenya</option>
                                                        <option value="Kiribati">Kiribati</option>
                                                        <option value="Korea, Democratic People's Republic of">Korea,
                                                            Democratic People's Republic of</option>
                                                        <option value="Korea, Republic of">Korea, Republic of</option>
                                                        <option value="Kuwait">Kuwait</option>
                                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                        <option value="Lao, People's Democratic Republic">Lao, People's
                                                            Democratic Republic</option>
                                                        <option value="Latvia">Latvia</option>
                                                        <option value="Lebanon">Lebanon</option>
                                                        <option value="Lesotho">Lesotho</option>
                                                        <option value="Liberia">Liberia</option>
                                                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya
                                                        </option>
                                                        <option value="Liechtenstein">Liechtenstein</option>
                                                        <option value="Lithuania">Lithuania</option>
                                                        <option value="Luxembourg">Luxembourg</option>
                                                        <option value="Macau">Macau</option>
                                                        <option value="Macedonia, The Former Yugoslav Republic of">
                                                            Macedonia, The Former Yugoslav Republic of</option>
                                                        <option value="Madagascar">Madagascar</option>
                                                        <option value="Malawi">Malawi</option>
                                                        <option value="Malaysia">Malaysia</option>
                                                        <option value="Maldives">Maldives</option>
                                                        <option value="Mali">Mali</option>
                                                        <option value="Malta">Malta</option>
                                                        <option value="Marshall Islands">Marshall Islands</option>
                                                        <option value="Martinique">Martinique</option>
                                                        <option value="Mauritania">Mauritania</option>
                                                        <option value="Mauritius">Mauritius</option>
                                                        <option value="Mayotte">Mayotte</option>
                                                        <option value="Mexico">Mexico</option>
                                                        <option value="Micronesia, Federated States of">Micronesia,
                                                            Federated States of</option>
                                                        <option value="Moldova, Republic of">Moldova, Republic of
                                                        </option>
                                                        <option value="Monaco">Monaco</option>
                                                        <option value="Mongolia">Mongolia</option>
                                                        <option value="Montserrat">Montserrat</option>
                                                        <option value="Morocco">Morocco</option>
                                                        <option value="Mozambique">Mozambique</option>
                                                        <option value="Myanmar">Myanmar</option>
                                                        <option value="Namibia">Namibia</option>
                                                        <option value="Nauru">Nauru</option>
                                                        <option value="Nepal">Nepal</option>
                                                        <option value="Netherlands">Netherlands</option>
                                                        <option value="Netherlands Antilles">Netherlands Antilles
                                                        </option>
                                                        <option value="New Caledonia">New Caledonia</option>
                                                        <option value="New Zealand">New Zealand</option>
                                                        <option value="Nicaragua">Nicaragua</option>
                                                        <option value="Niger">Niger</option>
                                                        <option value="Nigeria">Nigeria</option>
                                                        <option value="Niue">Niue</option>
                                                        <option value="Norfolk Island">Norfolk Island</option>
                                                        <option value="Northern Mariana Islands">Northern Mariana
                                                            Islands</option>
                                                        <option value="Norway">Norway</option>
                                                        <option value="Oman">Oman</option>
                                                        <option value="Pakistan">Pakistan</option>
                                                        <option value="Palau">Palau</option>
                                                        <option value="Panama">Panama</option>
                                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                                        <option value="Paraguay">Paraguay</option>
                                                        <option value="Peru">Peru</option>
                                                        <option value="Philippines">Philippines</option>
                                                        <option value="Pitcairn">Pitcairn</option>
                                                        <option value="Poland">Poland</option>
                                                        <option value="Portugal">Portugal</option>
                                                        <option value="Puerto Rico">Puerto Rico</option>
                                                        <option value="Qatar">Qatar</option>
                                                        <option value="Reunion">Reunion</option>
                                                        <option value="Romania">Romania</option>
                                                        <option value="Russian Federation">Russian Federation</option>
                                                        <option value="Rwanda">Rwanda</option>
                                                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis
                                                        </option>
                                                        <option value="Saint Lucia">Saint Lucia</option>
                                                        <option value="Saint Vincent and the Grenadines">Saint Vincent
                                                            and the Grenadines</option>
                                                        <option value="Samoa">Samoa</option>
                                                        <option value="San Marino">San Marino</option>
                                                        <option value="Sao Tome and Principe">Sao Tome and Principe
                                                        </option>
                                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                                        <option value="Senegal">Senegal</option>
                                                        <option value="Seychelles">Seychelles</option>
                                                        <option value="Sierra Leone">Sierra Leone</option>
                                                        <option value="Singapore">Singapore</option>
                                                        <option value="Slovakia (Slovak Republic)">Slovakia (Slovak
                                                            Republic)</option>
                                                        <option value="Slovenia">Slovenia</option>
                                                        <option value="Solomon Islands">Solomon Islands</option>
                                                        <option value="Somalia">Somalia</option>
                                                        <option value="South Africa">South Africa</option>
                                                        <option value="South Georgia and the South Sandwich Islands">
                                                            South Georgia and the South Sandwich Islands</option>
                                                        <option value="Spain">Spain</option>
                                                        <option value="Sri Lanka">Sri Lanka</option>
                                                        <option value="St. Helena">St. Helena</option>
                                                        <option value="St. Pierre and Miquelon">St. Pierre and Miquelon
                                                        </option>
                                                        <option value="Sudan">Sudan</option>
                                                        <option value="Suriname">Suriname</option>
                                                        <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan
                                                            Mayen Islands</option>
                                                        <option value="Swaziland">Swaziland</option>
                                                        <option value="Sweden">Sweden</option>
                                                        <option value="Switzerland">Switzerland</option>
                                                        <option value="Syrian Arab Republic">Syrian Arab Republic
                                                        </option>
                                                        <option value="Taiwan, Province of China">Taiwan, Province of
                                                            China</option>
                                                        <option value="Tajikistan">Tajikistan</option>
                                                        <option value="Tanzania, United Republic of">Tanzania, United
                                                            Republic of</option>
                                                        <option value="Thailand">Thailand</option>
                                                        <option value="Togo">Togo</option>
                                                        <option value="Tokelau">Tokelau</option>
                                                        <option value="Tonga">Tonga</option>
                                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                        <option value="Tunisia">Tunisia</option>
                                                        <option value="Turkey">Turkey</option>
                                                        <option value="Turkmenistan">Turkmenistan</option>
                                                        <option value="Turks and Caicos Islands">Turks and Caicos
                                                            Islands</option>
                                                        <option value="Tuvalu">Tuvalu</option>
                                                        <option value="Uganda">Uganda</option>
                                                        <option value="Ukraine">Ukraine</option>
                                                        <option value="United Arab Emirates">United Arab Emirates
                                                        </option>
                                                        <option value="United Kingdom">United Kingdom</option>
                                                        <option value="United States">United States</option>
                                                        <option value="United States Minor Outlying Islands">United
                                                            States Minor Outlying Islands</option>
                                                        <option value="Uruguay">Uruguay</option>
                                                        <option value="Uzbekistan">Uzbekistan</option>
                                                        <option value="Vanuatu">Vanuatu</option>
                                                        <option value="Venezuela">Venezuela</option>
                                                        <option value="Vietnam">Vietnam</option>
                                                        <option value="Virgin Islands (British)">Virgin Islands
                                                            (British)</option>
                                                        <option value="Virgin Islands (U.S.)">Virgin Islands (U.S.)
                                                        </option>
                                                        <option value="Wallis and Futuna Islands">Wallis and Futuna
                                                            Islands</option>
                                                        <option value="Western Sahara">Western Sahara</option>
                                                        <option value="Yemen">Yemen</option>
                                                        <option value="Yugoslavia">Yugoslavia</option>
                                                        <option value="Zambia">Zambia</option>
                                                        <option value="Zimbabwe">Zimbabwe</option>
                                                    </select></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3"><label class="form-label"
                                                        for="form-wizard-card-holder-zip-code">Zip Code</label><input
                                                        class="form-control" placeholder="1234" name="zipCode"
                                                        type="text" id="form-wizard-card-holder-zip-code"></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-0"><label class="form-label"
                                                        for="form-wizard-card-exp-date">Exp Date</label><input
                                                        class="form-control" placeholder="15/2024" name="expDate"
                                                        type="text" id="form-wizard-card-exp-date"></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-0"><label class="form-label"
                                                        for="form-wizard-card-cvv">CVV</label><span class="ms-1"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                        data-bs-original-title="Card verification value"
                                                        aria-label="Card verification value"><svg
                                                            class="svg-inline--fa fa-question-circle fa-w-16"
                                                            aria-hidden="true" focusable="false" data-prefix="fa"
                                                            data-icon="question-circle" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zM262.655 90c-54.497 0-89.255 22.957-116.549 63.758-3.536 5.286-2.353 12.415 2.715 16.258l34.699 26.31c5.205 3.947 12.621 3.008 16.665-2.122 17.864-22.658 30.113-35.797 57.303-35.797 20.429 0 45.698 13.148 45.698 32.958 0 14.976-12.363 22.667-32.534 33.976C247.128 238.528 216 254.941 216 296v4c0 6.627 5.373 12 12 12h56c6.627 0 12-5.373 12-12v-1.333c0-28.462 83.186-29.647 83.186-106.667 0-58.002-60.165-102-116.531-102zM256 338c-25.365 0-46 20.635-46 46 0 25.364 20.635 46 46 46s46-20.636 46-46c0-25.365-20.635-46-46-46z">
                                                            </path>
                                                        </svg>
                                                        <!-- <span class="fa fa-question-circle"></span> Font Awesome fontawesome.com --></span><input
                                                        class="form-control" placeholder="123" name="cvv" maxlength="3"
                                                        pattern="[0-9]{3}" type="text" id="form-wizard-card-cvv"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="form-wizard-tab4" id="form-wizard-tab4">
                                    <div class="wizard-lottie-wrapper">
                                        <div class="lottie wizard-lottie mx-auto my-3"
                                            data-options="{&quot;path&quot;:&quot;../../assets/img/animated-icons/celebration.json&quot;}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 464" width="264"
                                                height="464" preserveAspectRatio="xMidYMid meet"
                                                style="width: 100%; height: 100%; transform: translate3d(0px, 0px, 0px);">
                                                <defs>
                                                    <clipPath id="__lottie_element_25">
                                                        <rect width="264" height="464" x="0" y="0"></rect>
                                                    </clipPath>
                                                </defs>
                                                <g clip-path="url(#__lottie_element_25)">
                                                    <g transform="matrix(1,0,0,1,132,232)" opacity="1"
                                                        style="display: block;">
                                                        <g opacity="1" transform="matrix(1,0,0,1,0,147)">
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(203,240,248)"
                                                                                    fill-opacity="1"
                                                                                    d=" M-0.8989999890327454,80.08599853515625 C-0.7940000295639038,80.78700256347656 -0.7200000286102295,81.48899841308594 -0.6759999990463257,82.19000244140625 C-0.34200000762939453,87.56099700927734 -1.4980000257492065,93.02899932861328 -3.9690001010894775,97.80599975585938 C-5.301000118255615,100.37899780273438 -7.017000198364258,101.64800262451172 -10.517999649047852,102.7229995727539 C-11.420000076293945,105.37799835205078 -12.321000099182129,108.03399658203125 -13.111000061035156,109.33300018310547 C-13.656000137329102,110.42500305175781 -14.842000007629395,111.00900268554688 -15.972000122070312,110.91600036621094 C-17.53499984741211,110.55899810791016 -18.777999877929688,109.09200286865234 -18.628999710083008,107.28500366210938 C-18.628999710083008,107.28500366210938 -18.349000930786133,103.89600372314453 -18.349000930786133,103.89600372314453 C-20.174999237060547,103.97200012207031 -22.226999282836914,104.02999877929688 -24.260000228881836,103.86199951171875 C-25.840999603271484,103.73100280761719 -27.19700050354004,103.61900329589844 -28.760000228881836,103.26200103759766 C-28.760000228881836,103.26200103759766 -29.020999908447266,106.42500305175781 -29.020999908447266,106.42500305175781 C-29.170000076293945,108.23200225830078 -30.658000946044922,109.7020034790039 -32.23899841308594,109.57099914550781 C-33.36899948120117,109.47799682617188 -34.44200134277344,108.70700073242188 -34.79999923706055,107.54000091552734 C-35.36600112915039,106.12799835205078 -35.8390007019043,103.58699798583984 -36.31100082397461,101.0459976196289 C-37.946998596191406,100.31199645996094 -39.60300064086914,99.375 -40.85200119018555,98.06600189208984 C-42.0890007019043,96.76899719238281 -42.893001556396484,95.11699676513672 -43.507999420166016,93.45099639892578 C-45.91400146484375,86.9280014038086 -45.12699890136719,78.70800018310547 -41.91999816894531,72.60299682617188 C-38.14099884033203,65.40899658203125 -29.33300018310547,60.678001403808594 -20.74799919128418,61.38800048828125 C-15.503000259399414,61.821998596191406 -10.42300033569336,64.2509994506836 -6.7129998207092285,67.97000122070312 C-3.507999897003174,71.18299865722656 -1.5720000267028809,75.59100341796875 -0.8989999890327454,80.08599853515625z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9626547694206238,-0.27073192596435547,0.27073192596435547,0.9626547694206238,-21.555295944213867,-7.256439208984375)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M-42.0629997253418,75.07499694824219 C-42.13100051879883,72.34600067138672 -43.540000915527344,62.6150016784668 -43.31999969482422,60.858001708984375 C-43.111000061035156,59.422000885009766 -42.117000579833984,58.492000579833984 -40.979000091552734,58.04999923706055 C-39.20000076293945,57.62900161743164 -37.465999603271484,58.4900016784668 -37.04499816894531,60.26900100708008 C-37.04499816894531,60.26900100708008 -33.599998474121094,71.36100006103516 -33.599998474121094,71.36100006103516">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9472114443778992,0.32060956954956055,-0.32060956954956055,0.9472114443778992,23.322641372680664,5.966712951660156)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M-1.7050000429153442,77.16000366210938 C-0.7760000228881836,74.59300231933594 1.805999994277954,67.54199981689453 2.1540000438690186,65.80599975585938 C2.4110000133514404,64.37699890136719 1.7619999647140503,63.180999755859375 0.8230000138282776,62.4010009765625 C-0.7300000190734863,61.4379997253418 -2.6480000019073486,61.70500183105469 -3.6110000610351562,63.257999420166016 C-3.6110000610351562,63.257999420166016 -9.840999603271484,71.70099639892578 -9.840999603271484,71.70099639892578">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(1,0,0,0.7300000190734863,0,16.554397583007812)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(36,193,224)" fill-opacity="1"
                                                                            d=" M-18.285999298095703,71.75299835205078 C-18.694000244140625,71.70500183105469 -19.139999389648438,71.98400115966797 -19.187999725341797,72.39199829101562 C-19.22599983215332,72.71600341796875 -19.76300048828125,75.17500305175781 -22.716999053955078,74.87100219726562 C-25.66200065612793,74.48400115966797 -25.614999771118164,71.96800231933594 -25.57699966430664,71.64399719238281 C-25.52899932861328,71.23600006103516 -25.89900016784668,70.86199951171875 -26.30699920654297,70.81400299072266 C-26.71500015258789,70.76599884033203 -27.089000701904297,71.13600158691406 -27.136999130249023,71.54399871826172 C-27.22800064086914,73.02300262451172 -26.492000579833984,75.9219970703125 -22.899999618530273,76.34300231933594 C-22.895999908447266,76.34300231933594 -22.89299964904785,76.34400177001953 -22.888999938964844,76.34400177001953 C-22.88599967956543,76.34500122070312 -22.882999420166016,76.34600067138672 -22.878999710083008,76.34600067138672 C-19.28700065612793,76.76699829101562 -17.900999069213867,74.11499786376953 -17.64699935913086,72.65499877929688 C-17.599000930786133,72.24700164794922 -17.878000259399414,71.8010025024414 -18.285999298095703,71.75299835205078z M-16.341999053955078,65.36100006103516 C-15.125,65.50399780273438 -14.253000259399414,66.60600280761719 -14.395999908447266,67.822998046875 C-14.538999557495117,69.04000091552734 -15.642000198364258,69.91200256347656 -16.858999252319336,69.76899719238281 C-18.076000213623047,69.6259994506836 -18.94700050354004,68.52400207519531 -18.804000854492188,67.30699920654297 C-18.660999298095703,66.08999633789062 -17.55900001525879,65.21800231933594 -16.341999053955078,65.36100006103516z M-27.2810001373291,64.08000183105469 C-26.06399917602539,64.2229995727539 -25.191999435424805,65.32499694824219 -25.334999084472656,66.54199981689453 C-25.47800064086914,67.75900268554688 -26.579999923706055,68.63099670410156 -27.797000885009766,68.48799896240234 C-29.013999938964844,68.34500122070312 -29.88599967956543,67.24299621582031 -29.743000030517578,66.0260009765625 C-29.600000381469727,64.80899810791016 -28.49799919128418,63.9370002746582 -27.2810001373291,64.08000183105469z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(209,226,253)"
                                                                                    fill-opacity="1"
                                                                                    d=" M54.680999755859375,82.1780014038086 C54.84299850463867,82.86799621582031 54.97600173950195,83.56099700927734 55.07699966430664,84.25599670410156 C55.85300064086914,89.58100128173828 55.150001525878906,95.1259994506836 53.08100128173828,100.08999633789062 C51.965999603271484,102.76399993896484 50.361000061035156,104.1709976196289 46.96099853515625,105.53099822998047 C46.28099822998047,108.2509994506836 45.599998474121094,110.97100067138672 44.91999816894531,112.33100128173828 C44.46699905395508,113.46399688720703 43.33300018310547,114.1449966430664 42.20000076293945,114.1449966430664 C40.612998962402344,113.91799926757812 39.25299835205078,112.55899810791016 39.25299835205078,110.74500274658203 C39.25299835205078,110.74500274658203 39.25299835205078,107.34400177001953 39.25299835205078,107.34400177001953 C37.43899917602539,107.57099914550781 35.39899826049805,107.7979965209961 33.35900115966797,107.7979965209961 C31.77199935913086,107.7979965209961 30.41200065612793,107.7979965209961 28.825000762939453,107.57099914550781 C28.825000762939453,107.57099914550781 28.825000762939453,110.74500274658203 28.825000762939453,110.74500274658203 C28.825000762939453,112.55899810791016 27.46500015258789,114.1449966430664 25.878000259399414,114.1449966430664 C24.7450008392334,114.1449966430664 23.611000061035156,113.46399688720703 23.158000946044922,112.33100128173828 C22.47800064086914,110.97100067138672 21.797000885009766,108.47799682617188 21.117000579833984,105.98400115966797 C19.426000595092773,105.38700103759766 17.698999404907227,104.58999633789062 16.34600067138672,103.38800048828125 C15.005999565124512,102.1969985961914 14.069000244140625,100.61799621582031 13.319000244140625,99.00800323486328 C10.383999824523926,92.70500183105469 10.489999771118164,84.447998046875 13.182999610900879,78.0999984741211 C16.35700035095215,70.61900329589844 24.7450008392334,65.17900085449219 33.35900115966797,65.17900085449219 C38.62200164794922,65.17900085449219 43.88399887084961,67.18099975585938 47.88800048828125,70.58200073242188 C51.34700012207031,73.5199966430664 53.63999938964844,77.75399780273438 54.680999755859375,82.1780014038086z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9887012839317322,-0.1498991847038269,0.1498991847038269,0.9887012839317322,-11.94471263885498,3.27239990234375)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M11.956000328063965,83.19000244140625 C11.663999557495117,80.47599792480469 9.456000328063965,70.89399719238281 9.531000137329102,69.125 C9.621000289916992,67.6760025024414 10.53499984741211,66.66899871826172 11.631999969482422,66.13400268554688 C13.369999885559082,65.56800079345703 15.170000076293945,66.28399658203125 15.736000061035156,68.02200317382812 C15.736000061035156,68.02200317382812 20.083999633789062,78.79199981689453 20.083999633789062,78.79199981689453">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9879620671272278,0.15469631552696228,-0.15469631552696228,0.9879620671272278,13.023174285888672,-6.683418273925781)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M54.70100021362305,82.08300018310547 C55.41600036621094,79.447998046875 57.40700149536133,72.20899963378906 57.611000061035156,70.44999694824219 C57.749000549316406,69.00499725341797 57.005001068115234,67.86599731445312 56.005001068115234,67.16600036621094 C54.37699890136719,66.33399963378906 52.48699951171875,66.75800323486328 51.654998779296875,68.38600158691406 C51.654998779296875,68.38600158691406 46.141998291015625,77.31300354003906 46.141998291015625,77.31300354003906">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                            d=" M29.184999465942383,74.53700256347656 C28.781999588012695,74.51599884033203 28.437999725341797,74.9020004272461 28.41699981689453,75.30500030517578 C28.42099952697754,76.76100158691406 29.323999404907227,79.55799865722656 32.87200164794922,79.74500274658203 C36.41999816894531,79.93199920654297 37.612998962402344,77.24600219726562 37.77000045776367,75.79900360107422 C37.85100173950195,75.3219985961914 37.6510009765625,74.98400115966797 37.24800109863281,74.96299743652344 C37.24800109863281,74.96299743652344 29.184999465942383,74.53700256347656 29.184999465942383,74.53700256347656z M38.86899948120117,69.66600036621094 C40.090999603271484,69.76300048828125 41.00299835205078,70.83100128173828 40.90599822998047,72.0530014038086 C40.808998107910156,73.2750015258789 39.74100112915039,74.18699645996094 38.51900100708008,74.08999633789062 C37.297000885009766,73.99299621582031 36.3849983215332,72.92500305175781 36.481998443603516,71.7030029296875 C36.57899856567383,70.48100280761719 37.64699935913086,69.56900024414062 38.86899948120117,69.66600036621094z M27.889999389648438,68.7959976196289 C29.11199951171875,68.89299774169922 30.02400016784668,69.96099853515625 29.927000045776367,71.18299865722656 C29.829999923706055,72.40499877929688 28.761999130249023,73.31700134277344 27.540000915527344,73.22000122070312 C26.31800079345703,73.12300109863281 25.4060001373291,72.05500030517578 25.503000259399414,70.83300018310547 C25.600000381469727,69.61100006103516 26.667999267578125,68.6989974975586 27.889999389648438,68.7959976196289z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(209,226,253)"
                                                                                    fill-opacity="1"
                                                                                    d=" M-55.22200012207031,79.56400299072266 C-55.09600067138672,80.26100158691406 -55,80.96199798583984 -54.93600082397461,81.66100311279297 C-54.44200134277344,87.01899719238281 -55.435001373291016,92.51899719238281 -57.76300048828125,97.36699676513672 C-59.018001556396484,99.97899627685547 -60.69499969482422,101.29900360107422 -64.16200256347656,102.47799682617188 C-64.98400115966797,105.15899658203125 -65.80699920654297,107.83999633789062 -66.55799865722656,109.16200256347656 C-67.06999969482422,110.2699966430664 -68.23799896240234,110.88899993896484 -69.37000274658203,110.8290023803711 C-70.94300079345703,110.51899719238281 -72.2300033569336,109.08899688720703 -72.13400268554688,107.27799987792969 C-72.13400268554688,107.27799987792969 -71.95500183105469,103.88300323486328 -71.95500183105469,103.88300323486328 C-73.77799987792969,104.01399993896484 -75.8270034790039,104.13300323486328 -77.86399841308594,104.0250015258789 C-79.4489974975586,103.94100189208984 -80.80699920654297,103.87000274658203 -82.37999725341797,103.55999755859375 C-82.37999725341797,103.55999755859375 -82.5469970703125,106.72899627685547 -82.5469970703125,106.72899627685547 C-82.64299774169922,108.54000091552734 -84.08399963378906,110.0530014038086 -85.66899871826172,109.96900177001953 C-86.8010025024414,109.90899658203125 -87.89700317382812,109.1709976196289 -88.29000091552734,108.01499938964844 C-88.89700317382812,106.62100219726562 -89.44499969482422,104.09500122070312 -89.99299621582031,101.56900024414062 C-91.6500015258789,100.88400268554688 -93.33399963378906,99.99800109863281 -94.62100219726562,98.72599792480469 C-95.89600372314453,97.46600341796875 -96.75,95.83899688720703 -97.41400146484375,94.19200134277344 C-100.01300048828125,87.74299621582031 -99.47100067138672,79.50299835205078 -96.4469985961914,73.30599975585938 C-92.88300323486328,66.00299835205078 -84.22100067138672,61.01100158691406 -75.61900329589844,61.46500015258789 C-70.36299896240234,61.742000579833984 -65.21399688720703,64.0199966430664 -61.39400100708008,67.62699890136719 C-58.09400177001953,70.74299621582031 -56.02899932861328,75.09100341796875 -55.22200012207031,79.56400299072266z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.985862672328949,-0.16755527257919312,0.16755527257919312,0.985862672328949,-13.97174072265625,-14.784881591796875)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M-97.94100189208984,78.3239974975586 C-98.08999633789062,75.5979995727539 -99.79000091552734,65.91400146484375 -99.62200164794922,64.1510009765625 C-99.45600128173828,62.70899963378906 -98.48899841308594,61.750999450683594 -97.36499786376953,61.275001525878906 C-95.5999984741211,60.801998138427734 -93.83999633789062,61.611000061035156 -93.36699676513672,63.375999450683594 C-93.36699676513672,63.375999450683594 -89.59200286865234,74.36000061035156 -89.59200286865234,74.36000061035156">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.985862672328949,0.16755527257919312,-0.16755527257919312,0.985862672328949,12.070873260498047,11.306198120117188)">
                                                                            <path fill="rgb(209,226,253)"
                                                                                fill-opacity="1"
                                                                                d=" M-55.196998596191406,79.47100067138672 C-54.345001220703125,76.87799835205078 -51.9739990234375,69.75299835205078 -51.678001403808594,68.00700378417969 C-51.4640007019043,66.57099914550781 -52.14699935913086,65.3949966430664 -53.10900115966797,64.64299774169922 C-54.689998626708984,63.72700119018555 -56.60100173950195,64.0510025024414 -57.516998291015625,65.63200378417969 C-57.516998291015625,65.63200378417969 -63.492000579833984,74.25599670410156 -63.492000579833984,74.25599670410156">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(1,0,0,0.75,0,15.995750427246094)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                            d=" M-80.1050033569336,63.73099899291992 C-81.23400115966797,63.55500030517578 -82.35199737548828,64.11599731445312 -82.88700103759766,65.1259994506836 C-82.9990005493164,65.33799743652344 -83.0009994506836,65.58499908447266 -82.89199829101562,65.802001953125 C-82.78199768066406,66.02200317382812 -82.57099914550781,66.17500305175781 -82.3290023803711,66.21299743652344 C-82.01499938964844,66.26200103759766 -81.70099639892578,66.1050033569336 -81.5469970703125,65.82099914550781 C-81.31099700927734,65.38600158691406 -80.82499694824219,65.1449966430664 -80.33699798583984,65.22100067138672 C-79.8489990234375,65.2969970703125 -79.45999908447266,65.67400360107422 -79.36799621582031,66.16000366210938 C-79.30699920654297,66.47699737548828 -79.05599975585938,66.7229995727539 -78.74199676513672,66.77200317382812 C-78.5,66.80999755859375 -78.25199890136719,66.72699737548828 -78.08100128173828,66.5510025024414 C-77.91100311279297,66.37699890136719 -77.83799743652344,66.14099884033203 -77.87999725341797,65.90499877929688 C-78.08200073242188,64.77999877929688 -78.97599792480469,63.90700149536133 -80.1050033569336,63.73099899291992z M-66.40899658203125,67.69200134277344 C-66.61100006103516,66.56700134277344 -67.50499725341797,65.69300079345703 -68.63400268554688,65.51699829101562 C-69.76300048828125,65.34100341796875 -70.87999725341797,65.9020004272461 -71.41500091552734,66.91200256347656 C-71.5270004272461,67.1240005493164 -71.52899932861328,67.37100219726562 -71.41999816894531,67.58799743652344 C-71.30999755859375,67.80799865722656 -71.0999984741211,67.96099853515625 -70.85800170898438,67.9990005493164 C-70.54399871826172,68.0479965209961 -70.2300033569336,67.89099884033203 -70.07599639892578,67.60700225830078 C-69.83999633789062,67.1719970703125 -69.35399627685547,66.93099975585938 -68.86599731445312,67.00700378417969 C-68.37799835205078,67.08300018310547 -67.98799896240234,67.45999908447266 -67.89600372314453,67.94599914550781 C-67.83499908447266,68.26300048828125 -67.58499908447266,68.50900268554688 -67.27100372314453,68.55799865722656 C-67.02899932861328,68.59600067138672 -66.78099822998047,68.51300048828125 -66.60900115966797,68.33699798583984 C-66.43900299072266,68.16300201416016 -66.36699676513672,67.9280014038086 -66.40899658203125,67.69200134277344z M-71.51799774169922,70.24299621582031 C-71.8489990234375,70.19200134277344 -72.15399932861328,70.41600036621094 -72.27200317382812,70.73600006103516 C-72.28199768066406,70.802001953125 -72.76399993896484,73.02899932861328 -75.2770004272461,72.63800048828125 C-77.7239990234375,72.25700378417969 -77.60299682617188,70.177001953125 -77.56199645996094,69.91200256347656 C-77.51100158691406,69.58100128173828 -77.80000305175781,69.26499938964844 -78.13099670410156,69.21399688720703 C-78.46199798583984,69.16300201416016 -78.77799987792969,69.45099639892578 -78.8290023803711,69.78199768066406 C-78.947998046875,70.98300170898438 -78.43900299072266,73.36499786376953 -75.52899932861328,73.81800079345703 C-72.61900329589844,74.27100372314453 -71.40899658203125,72.15699768066406 -71.15799713134766,70.97699737548828 C-70.9739990234375,70.66699981689453 -71.18699645996094,70.29399871826172 -71.51799774169922,70.24299621582031z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                            <g opacity="1"
                                                                                transform="matrix(1,0,0,1,0,0)">
                                                                                <path fill="rgb(203,240,248)"
                                                                                    fill-opacity="1"
                                                                                    d=" M106.04000091552734,74.5270004272461 C106.322998046875,75.1760025024414 106.5790023803711,75.83599853515625 106.8030014038086,76.5009994506836 C108.52200317382812,81.5999984741211 108.82599639892578,87.18099975585938 107.68199920654297,92.43599700927734 C107.06500244140625,95.26699829101562 105.73799896240234,96.93900299072266 102.63700103759766,98.88700103759766 C102.45600128173828,101.68499755859375 102.2760009765625,104.48300170898438 101.85099792480469,105.94300079345703 C101.60800170898438,107.13899993896484 100.61499786376953,108.01300048828125 99.5,108.21600341796875 C97.89800262451172,108.27799987792969 96.31700134277344,107.18399810791016 95.99099731445312,105.4000015258789 C95.99099731445312,105.4000015258789 95.37999725341797,102.05400085449219 95.37999725341797,102.05400085449219 C93.63700103759766,102.60299682617188 91.66999816894531,103.19200134277344 89.66300201416016,103.55799865722656 C88.10199737548828,103.84300231933594 86.76399993896484,104.08699798583984 85.16200256347656,104.14900207519531 C85.16200256347656,104.14900207519531 85.73200225830078,107.27100372314453 85.73200225830078,107.27100372314453 C86.05799865722656,109.05500030517578 85.00399780273438,110.86100006103516 83.44300079345703,111.14600372314453 C82.3280029296875,111.3489990234375 81.09100341796875,110.88400268554688 80.44200134277344,109.8499984741211 C79.52899932861328,108.63400268554688 78.41200256347656,106.3030014038086 77.29499816894531,103.97200012207031 C75.52400207519531,103.68800354003906 73.68099975585938,103.21499633789062 72.13500213623047,102.2750015258789 C70.60299682617188,101.34400177001953 69.39800262451172,99.95800018310547 68.37100219726562,98.50900268554688 C64.35199737548828,92.83599853515625 62.9739990234375,84.69300079345703 64.48400115966797,77.96499633789062 C66.26300048828125,70.03600311279297 73.53800201416016,63.178001403808594 82.01300048828125,61.63199996948242 C87.19100189208984,60.6870002746582 92.72599792480469,61.71200180053711 97.2760009765625,64.33899688720703 C101.20600128173828,66.60800170898438 104.22100067138672,70.36199951171875 106.04000091552734,74.5270004272461z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9602928161621094,-0.27899405360221863,0.27899405360221863,0.9602928161621094,-19.180404663085938,21.982925415039062)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M64.19000244140625,83.19300079345703 C63.415000915527344,80.57499694824219 59.52399826049805,71.5459976196289 59.279998779296875,69.79199981689453 C59.10900115966797,68.35099792480469 59.82699966430664,67.19499969482422 60.81100082397461,66.47200012207031 C62.41899871826172,65.60299682617188 64.31800079345703,65.98400115966797 65.18699645996094,67.59200286865234 C65.18699645996094,67.59200286865234 71.39700317382812,77.40699768066406 71.39700317382812,77.40699768066406">
                                                                            </path>
                                                                        </g>
                                                                        <g opacity="1"
                                                                            transform="matrix(0.9807589054107666,0.19522295892238617,-0.19522295892238617,0.9807589054107666,16.017059326171875,-18.259262084960938)">
                                                                            <path fill="rgb(203,240,248)"
                                                                                fill-opacity="1"
                                                                                d=" M106.04299926757812,74.43099975585938 C106.27300262451172,71.71099853515625 106.93199920654297,64.23100280761719 106.81700134277344,62.4640007019043 C106.69400024414062,61.018001556396484 105.75599670410156,60.03200149536133 104.64700317382812,59.52199935913086 C102.89700317382812,58.99599838256836 101.11399841308594,59.75199890136719 100.58799743652344,61.50199890136719 C100.58799743652344,61.50199890136719 96.76699829101562,71.27400207519531 96.76699829101562,71.27400207519531">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(36,193,224)" fill-opacity="1"
                                                                            d=" M85.03199768066406,68.8239974975586 C84.63999938964844,68.9469985961914 84.34600067138672,69.38400268554688 84.46900177001953,69.7760009765625 C84.56600189208984,70.08699798583984 85.08000183105469,72.5510025024414 82.25900268554688,73.47899627685547 C79.41300201416016,74.3270034790039 78.4280014038086,72.01000213623047 78.33100128173828,71.6989974975586 C78.20800018310547,71.30699920654297 77.71800231933594,71.11599731445312 77.32599639892578,71.23899841308594 C76.93399810791016,71.36199951171875 76.74299621582031,71.85199737548828 76.86599731445312,72.24400329589844 C77.38700103759766,73.63099670410156 79.24099731445312,75.97799682617188 82.69200134277344,74.89700317382812 C82.69599914550781,74.89600372314453 82.6989974975586,74.89399719238281 82.7020034790039,74.89299774169922 C82.70500183105469,74.89199829101562 82.70899963378906,74.89199829101562 82.71299743652344,74.89099884033203 C86.16400146484375,73.80999755859375 86.3479995727539,70.822998046875 85.98400115966797,69.38700103759766 C85.86100006103516,68.99500274658203 85.42400360107422,68.70099639892578 85.03199768066406,68.8239974975586z M84.61499786376953,63.027000427246094 C85.78399658203125,62.6609992980957 87.02999877929688,63.3120002746582 87.39600372314453,64.48100280761719 C87.76200103759766,65.6500015258789 87.11100006103516,66.89600372314453 85.94200134277344,67.26200103759766 C84.77300262451172,67.62799835205078 83.5270004272461,66.97699737548828 83.16100311279297,65.80799865722656 C82.79499816894531,64.63899993896484 83.44599914550781,63.393001556396484 84.61499786376953,63.027000427246094z M74.1050033569336,66.31999969482422 C75.27400207519531,65.9540023803711 76.52100372314453,66.6050033569336 76.88700103759766,67.77400207519531 C77.25299835205078,68.94300079345703 76.60099792480469,70.18900299072266 75.43199920654297,70.55500030517578 C74.26300048828125,70.9209976196289 73.01699829101562,70.2699966430664 72.6510009765625,69.10099792480469 C72.28500366210938,67.93199920654297 72.93599700927734,66.68599700927734 74.1050033569336,66.31999969482422z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g opacity="1"
                                                            transform="matrix(0.9970032572746277,0.07735968381166458,-0.07735968381166458,0.9970032572746277,1.6673016548156738,134.84996032714844)">
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(209,226,253)" fill-opacity="1"
                                                                            d=" M22.850000381469727,28.0939998626709 C22.364999771118164,28.86400032043457 21.849000930786133,29.608999252319336 21.30500030517578,30.327999114990234 C17.132999420166016,35.83599853515625 11.428000450134277,40.191001892089844 5.021999835968018,42.770999908447266 C1.5700000524520874,44.1609992980957 -1.1629999876022339,43.95899963378906 -5.4710001945495605,42.07400131225586 C-8.572999954223633,43.90299987792969 -11.673999786376953,45.731998443603516 -13.531000137329102,46.334999084472656 C-14.97599983215332,46.94200134277344 -16.621000289916992,46.518001556396484 -17.642000198364258,45.48099899291992 C-18.864999771118164,43.82500076293945 -18.844999313354492,41.35499954223633 -17.18600082397461,39.72100067138672 C-17.18600082397461,39.72100067138672 -14.076000213623047,36.65700149536133 -14.076000213623047,36.65700149536133 C-15.918000221252441,35.20199966430664 -17.964000701904297,33.540000915527344 -19.802000045776367,31.67300033569336 C-21.23200035095215,30.22100067138672 -22.457000732421875,28.976999282836914 -23.68000030517578,27.320999145507812 C-23.68000030517578,27.320999145507812 -26.58300018310547,30.180999755859375 -26.58300018310547,30.180999755859375 C-28.242000579833984,31.815000534057617 -30.920000076293945,32.000999450683594 -32.349998474121094,30.548999786376953 C-33.37099838256836,29.511999130249023 -33.77000045776367,27.86199951171875 -33.141998291015625,26.426000595092773 C-32.5099983215332,24.577999114990234 -30.840999603271484,21.708999633789062 -29.17300033569336,18.84000015258789 C-30.150999069213867,16.7549991607666 -30.979000091552734,14.456999778747559 -31.097999572753906,12.13599967956543 C-31.215999603271484,9.836999893188477 -30.615999221801758,7.556000232696533 -29.819000244140625,5.419000148773193 C-26.697999954223633,-2.946000099182129 -19.04800033569336,-10.288999557495117 -10.814000129699707,-13.545000076293945 C-1.1100000143051147,-17.382999420166016 11.425999641418457,-14.612000465393066 19.187999725341797,-6.730999946594238 C23.93000030517578,-1.9160000085830688 26.84000015258789,4.702000141143799 27.336999893188477,11.430000305175781 C27.766000747680664,17.242000579833984 25.958999633789062,23.155000686645508 22.850000381469727,28.0939998626709z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(0.8654884696006775,-0.5009288787841797,0.5009288787841797,0.8654884696006775,-3.6946983337402344,-7.068982124328613)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(209,226,253)" fill-opacity="1"
                                                                            d=" M-7.302999973297119,-6.633999824523926 C-7.302999973297119,-6.633999824523926 -7.98199987411499,-21.533000946044922 -7.98199987411499,-21.533000946044922 C-7.927000045776367,-23.878999710083008 -9.803000450134277,-25.511999130249023 -12.14900016784668,-25.566999435424805 C-13.706000328063965,-25.386999130249023 -15.243000030517578,-24.55699920654297 -15.968999862670898,-22.84000015258789 C-16.812999725341797,-20.729000091552734 -18.22100067138672,-8.180000305175781 -19.023000717163086,-4.76800012588501 C-19.023000717163086,-4.76800012588501 -7.302999973297119,-6.633999824523926 -7.302999973297119,-6.633999824523926z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1"
                                                                    transform="matrix(0.9329801201820374,0.3599279522895813,-0.3599279522895813,0.9329801201820374,9.798563003540039,-6.670827865600586)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(209,226,253)" fill-opacity="1"
                                                                            d=" M22.694000244140625,16.281999588012695 C22.694000244140625,16.281999588012695 19.381999969482422,28.62700080871582 19.381999969482422,28.62700080871582 C22.832000732421875,29.24799919128418 32.314998626708984,30.990999221801758 34.5880012512207,31.055999755859375 C36.45199966430664,31.07200050354004 37.82500076293945,29.993000030517578 38.61000061035156,28.63599967956543 C39.49300003051758,26.461000442504883 38.742000579833984,24.090999603271484 36.56700134277344,23.20800018310547 C36.56700134277344,23.20800018310547 22.694000244140625,16.281999588012695 22.694000244140625,16.281999588012695">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                        d=" M-1.2269999980926514,-1.253999948501587 C-1.4980000257492065,-1.5800000429153442 -2.0429999828338623,-1.5700000524520874 -2.36899995803833,-1.2990000247955322 C-3.490000009536743,-0.25699999928474426 -5.004000186920166,2.437000036239624 -2.615999937057495,5.309999942779541 C-0.2280000001192093,8.182999610900879 2.697000026702881,7.188000202178955 3.927000045776367,6.276000022888184 C4.353000164031982,5.999000072479248 4.4710001945495605,5.6020002365112305 4.199999809265137,5.276000022888184 C4.199999809265137,5.276000022888184 -1.2269999980926514,-1.253999948501587 -1.2269999980926514,-1.253999948501587z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(25,118,210)" fill-opacity="1"
                                                                        d=" M-3.5950000286102295,0.5690000057220459 C-4.074999809265137,1.8559999465942383 -4.079999923706055,3.5480000972747803 -2.615999937057495,5.309999942779541 C-1.7510000467300415,6.349999904632568 -0.8180000185966492,6.879000186920166 0.0820000022649765,7.0920000076293945 C0.17299999296665192,6.692999839782715 0.22599999606609344,6.28000020980835 0.22599999606609344,5.853000164031982 C0.22599999606609344,3.3889999389648438 -1.3769999742507935,1.3020000457763672 -3.5950000286102295,0.5690000057220459z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(225,247,249)" fill-opacity="1"
                                                                        d=" M23.834999084472656,10.664999961853027 C23.23699951171875,10.83899974822998 22.854999542236328,11.383000373840332 22.93000030517578,12.010000228881836 C23.347999572753906,15.670000076293945 20.679000854492188,17.636999130249023 20.679000854492188,17.636999130249023 C20.040000915527344,18.038999557495117 19.944000244140625,18.823999404907227 20.34600067138672,19.46299934387207 C20.74799919128418,20.101999282836914 21.533000946044922,20.19700050354004 22.172000885009766,19.795000076293945 C22.341999053955078,19.636999130249023 26.09000015258789,16.923999786376953 25.565000534057617,11.781999588012695 C25.461000442504883,11.055999755859375 24.888999938964844,10.574000358581543 24.163000106811523,10.678000450134277 C24.034000396728516,10.607000350952148 23.934999465942383,10.63599967956543 23.834999084472656,10.664999961853027z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(255,167,38)" fill-opacity="1"
                                                                        d=" M19.1560001373291,9.093999862670898 C15.958999633789062,12.027999877929688 10.989999771118164,11.8149995803833 8.055999755859375,8.618000030517578 C5.122000217437744,5.421000003814697 5.335000038146973,0.4519999921321869 8.531999588012695,-2.4820001125335693 C11.729000091552734,-5.415999889373779 16.697999954223633,-5.203000068664551 19.631999969482422,-2.00600004196167 C22.56599998474121,1.190999984741211 22.35300064086914,6.159999847412109 19.1560001373291,9.093999862670898z M6.388999938964844,-4.816999912261963 C3.191999912261963,-1.8830000162124634 -1.7769999504089355,-2.0969998836517334 -4.710999965667725,-5.294000148773193 C-7.644999980926514,-8.491000175476074 -7.432000160217285,-13.460000038146973 -4.235000133514404,-16.393999099731445 C-1.0379999876022339,-19.327999114990234 3.930999994277954,-19.11400032043457 6.864999771118164,-15.916999816894531 C9.798999786376953,-12.720000267028809 9.586000442504883,-7.750999927520752 6.388999938964844,-4.816999912261963z M9.54699993133545,-0.1979999989271164 C9.54699993133545,-0.1979999989271164 4.315999984741211,-5.896999835968018 4.315999984741211,-5.896999835968018 C4.315999984741211,-5.896999835968018 6.343999862670898,-7.757999897003174 6.343999862670898,-7.757999897003174 C6.343999862670898,-7.757999897003174 11.574999809265137,-2.059000015258789 11.574999809265137,-2.059000015258789 C11.574999809265137,-2.059000015258789 9.54699993133545,-0.1979999989271164 9.54699993133545,-0.1979999989271164z M23.389999389648438,3.885999917984009 C23.389999389648438,4.690999984741211 22.73699951171875,5.343999862670898 21.93199920654297,5.343999862670898 C21.12700080871582,5.343999862670898 20.474000930786133,4.690999984741211 20.474000930786133,3.885999917984009 C20.474000930786133,3.0810000896453857 21.12700080871582,2.427999973297119 21.93199920654297,2.427999973297119 C22.73699951171875,2.427999973297119 23.389999389648438,3.0810000896453857 23.389999389648438,3.885999917984009z M2.13100004196167,-18.613000869750977 C2.13100004196167,-17.808000564575195 1.4780000448226929,-17.15399932861328 0.6729999780654907,-17.15399932861328 C-0.13199999928474426,-17.15399932861328 -0.7860000133514404,-17.808000564575195 -0.7860000133514404,-18.613000869750977 C-0.7860000133514404,-19.417999267578125 -0.13199999928474426,-20.070999145507812 0.6729999780654907,-20.070999145507812 C1.4780000448226929,-20.070999145507812 2.13100004196167,-19.417999267578125 2.13100004196167,-18.613000869750977z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(66,133,244)" fill-opacity="1"
                                                                        d=" M17.871000289916992,7.693999767303467 C15.446999549865723,9.918000221252441 11.680000305175781,9.756999969482422 9.456000328063965,7.333000183105469 C7.23199987411499,4.908999919891357 7.392000198364258,1.1410000324249268 9.815999984741211,-1.0829999446868896 C12.239999771118164,-3.306999921798706 16.007999420166016,-3.1459999084472656 18.23200035095215,-0.722000002861023 C20.45599937438965,1.7020000219345093 20.295000076293945,5.46999979019165 17.871000289916992,7.693999767303467z M5.104000091552734,-6.2170000076293945 C2.680000066757202,-3.993000030517578 -1.0870000123977661,-4.1539998054504395 -3.311000108718872,-6.578000068664551 C-5.534999847412109,-9.001999855041504 -5.374000072479248,-12.770000457763672 -2.950000047683716,-14.994000434875488 C-0.5260000228881836,-17.218000411987305 3.240999937057495,-17.05699920654297 5.465000152587891,-14.633000373840332 C7.689000129699707,-12.208999633789062 7.5279998779296875,-8.440999984741211 5.104000091552734,-6.2170000076293945z">
                                                                    </path>
                                                                </g>
                                                                <g opacity="0.3" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(255,255,255)" fill-opacity="1"
                                                                        d=" M-4.666999816894531,-9.097999572753906 C-4.427999973297119,-8.194000244140625 -4,-7.328000068664551 -3.3239998817443848,-6.591000080108643 C-2.74399995803833,-5.959000110626221 -2.053999900817871,-5.488999843597412 -1.315000057220459,-5.166999816894531 C-1.315000057220459,-5.166999816894531 6.163000106811523,-7.5920000076293945 6.163000106811523,-7.5920000076293945 C7.125999927520752,-9.21500015258789 7.263000011444092,-11.190999984741211 6.534999847412109,-12.920999526977539 C6.534999847412109,-12.920999526977539 -4.666999816894531,-9.097999572753906 -4.666999816894531,-9.097999572753906z M8.112000465393066,4.826000213623047 C8.35099983215332,5.730000019073486 8.779999732971191,6.5960001945495605 9.456000328063965,7.333000183105469 C10.03600025177002,7.965000152587891 10.725000381469727,8.435999870300293 11.46399974822998,8.758000373840332 C11.46399974822998,8.758000373840332 18.941999435424805,6.333000183105469 18.941999435424805,6.333000183105469 C19.905000686645508,4.710000038146973 20.04199981689453,2.7339999675750732 19.31399917602539,1.003999948501587 C19.31399917602539,1.003999948501587 8.112000465393066,4.826000213623047 8.112000465393066,4.826000213623047z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                            <g opacity="1"
                                                                transform="matrix(0.7655283808708191,0.643402099609375,-0.643402099609375,0.7655283808708191,21.196701049804688,-42.246646881103516)">
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(203,240,248)" fill-opacity="1"
                                                                            d=" M46.28300094604492,-9.434000015258789 C46.28300094604492,-9.434000015258789 29.57900047302246,-8.812999725341797 29.57900047302246,-8.812999725341797 C29.1560001373291,-8.79699993133545 28.878000259399414,-8.366999626159668 29.03700065612793,-7.974999904632568 C29.03700065612793,-7.974999904632568 30.96500015258789,-3.2279999256134033 30.96500015258789,-3.2279999256134033 C30.96500015258789,-3.2279999256134033 31.507999420166016,-1.8919999599456787 31.507999420166016,-1.8919999599456787 C31.507999420166016,-1.8919999599456787 33.43600082397461,2.8519999980926514 33.43600082397461,2.8519999980926514 C33.59600067138672,3.244999885559082 34.095001220703125,3.359999895095825 34.409000396728516,3.075000047683716 C36.5880012512207,1.093999981880188 43.7140007019043,-5.385000228881836 46.79399871826172,-8.190999984741211 C47.2869987487793,-8.640999794006348 46.95000076293945,-9.458999633789062 46.28300094604492,-9.434000015258789z">
                                                                        </path>
                                                                    </g>
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(148,219,224)" fill-opacity="1"
                                                                            d=" M30.836999893188477,-3.5429999828338623 C30.836999893188477,-3.5429999828338623 38.24700164794922,-0.41499999165534973 38.24700164794922,-0.41499999165534973 C39.04600143432617,-1.1410000324249268 39.895999908447266,-1.9140000343322754 40.75199890136719,-2.693000078201294 C40.75199890136719,-2.693000078201294 29.20199966430664,-7.570000171661377 29.20199966430664,-7.570000171661377 C29.20199966430664,-7.570000171661377 30.836999893188477,-3.5429999828338623 30.836999893188477,-3.5429999828338623z">
                                                                        </path>
                                                                    </g>
                                                                    <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                        <path fill="rgb(148,219,224)" fill-opacity="1"
                                                                            d=" M34.09600067138672,-8.980999946594238 C34.09600067138672,-8.980999946594238 43.36399841308594,-5.067999839782715 43.36399841308594,-5.067999839782715 C44.27899932861328,-5.901000022888184 45.13399887084961,-6.678999900817871 45.86800003051758,-7.3470001220703125 C45.86800003051758,-7.3470001220703125 41.356998443603516,-9.25100040435791 41.356998443603516,-9.25100040435791 C41.356998443603516,-9.25100040435791 34.09600067138672,-8.980999946594238 34.09600067138672,-8.980999946594238z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                                <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                                                    <path fill="rgb(148,219,224)" fill-opacity="1"
                                                                        d=" M50.084999084472656,-9.02400016784668 C49.917999267578125,-7.9670000076293945 48.92499923706055,-7.245999813079834 47.86800003051758,-7.413000106811523 C46.81100082397461,-7.579999923706055 46.09000015258789,-8.572999954223633 46.25699996948242,-9.630000114440918 C46.42399978637695,-10.687000274658203 47.41699981689453,-11.407999992370605 48.4739990234375,-11.241000175476074 C49.53099822998047,-11.074000358581543 50.25199890136719,-10.081000328063965 50.084999084472656,-9.02400016784668z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g opacity="1" transform="matrix(1,0,0,1,0,147)">
                                                            <g opacity="1"
                                                                transform="matrix(-0.5650904774665833,0.8250289559364319,-0.8250289559364319,-0.5650904774665833,91.3857650756836,8.730224609375)">
                                                                <path fill="rgb(246,102,56)" fill-opacity="1"
                                                                    d=" M62.60100173950195,18.645999908447266 C60.78099822998047,23.586000442504883 56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 C56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 C56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 56.1879997253418,24.972999572753906 C56.1879997253418,24.972999572753906 60.867000579833984,26.358999252319336 62.513999938964844,31.298999786376953 C64.33399963378906,26.358999252319336 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 68.83999633789062,24.972999572753906 C68.927001953125,24.972999572753906 64.24800109863281,23.586000442504883 62.60100173950195,18.645999908447266">
                                                                </path>
                                                            </g>
                                                            <g opacity="0.46164800000012174"
                                                                transform="matrix(0.8673415780067444,0.16548582911491394,-0.16548582911491394,0.8673415780067444,2.2974586486816406,15.323638916015625)">
                                                                <path fill="rgb(253,202,64)" fill-opacity="1"
                                                                    d=" M-61.39899826049805,42.3129997253418 C-63.21900177001953,47.25299835205078 -67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 C-67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 C-67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 -67.81199645996094,48.638999938964844 C-67.81199645996094,48.638999938964844 -63.132999420166016,50.0260009765625 -61.486000061035156,54.965999603271484 C-59.66600036621094,50.0260009765625 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 -55.15999984741211,48.638999938964844 C-55.073001861572266,48.638999938964844 -59.75199890136719,47.25299835205078 -61.39899826049805,42.3129997253418">
                                                                </path>
                                                            </g>
                                                            <g opacity="1"
                                                                transform="matrix(0.3588069677352905,-0.9334117770195007,0.9334117770195007,0.3588069677352905,47.98061752319336,7.590810775756836)">
                                                                <path fill="rgb(253,202,64)" fill-opacity="1"
                                                                    d=" M29.243999481201172,-37.02000045776367 C27.90399932861328,-33.38199996948242 24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 C24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 C24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 24.520999908447266,-32.36000061035156 C24.520999908447266,-32.36000061035156 27.966999053955078,-31.339000701904297 29.18000030517578,-27.701000213623047 C30.520000457763672,-31.339000701904297 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 33.84000015258789,-32.36000061035156 C33.90399932861328,-32.36000061035156 30.457000732421875,-33.38199996948242 29.243999481201172,-37.02000045776367">
                                                                </path>
                                                            </g>
                                                            <g opacity="0.05137333333343491"
                                                                transform="matrix(0.6994892358779907,0.7146431803703308,-0.7146431803703308,0.6994892358779907,-17.679279327392578,38.45714569091797)">
                                                                <path fill="rgb(246,102,56)" fill-opacity="1"
                                                                    d=" M-54.15999984741211,-6.0269999504089355 C-55.42100143432617,-2.6040000915527344 -58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 C-58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 C-58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 -58.604000091552734,-1.6430000066757202 C-58.604000091552734,-1.6430000066757202 -55.361000061035156,-0.6819999814033508 -54.220001220703125,2.740999937057495 C-52.95899963378906,-0.6819999814033508 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 -49.834999084472656,-1.6430000066757202 C-49.775001525878906,-1.6430000066757202 -53.01900100708008,-2.6040000915527344 -54.15999984741211,-6.0269999504089355">
                                                                </path>
                                                            </g>
                                                            <g opacity="0"
                                                                transform="matrix(0.7782110571861267,-0.7887388467788696,0.7887388467788696,0.7782110571861267,-8.232227325439453,2.084207534790039)">
                                                                <path fill="rgb(255,255,255)" fill-opacity="1"
                                                                    d=" M-42.262001037597656,-30.163000106811523 C-41.54399871826172,-29.516000747680664 -41.487998962402344,-28.409000396728516 -42.1349983215332,-27.69099998474121 C-42.78200149536133,-26.972999572753906 -43.88800048828125,-26.91699981689453 -44.60599899291992,-27.56399917602539 M47.02899932861328,50.5369987487793 C48.38600158691406,49.99800109863281 49.92499923706055,50.6609992980957 50.4640007019043,52.018001556396484 C51.00299835205078,53.375 50.34000015258789,54.91299819946289 48.983001708984375,55.45199966430664">
                                                                </path>
                                                                <path fill="rgb(255,213,79)" fill-opacity="1"
                                                                    d=" M47.02899932861328,50.5369987487793 C48.38600158691406,49.99800109863281 49.92499923706055,50.6609992980957 50.4640007019043,52.018001556396484 C51.00299835205078,53.375 50.34000015258789,54.91299819946289 48.983001708984375,55.45199966430664">
                                                                </path>
                                                            </g>
                                                            <g opacity="0.038530000000076114"
                                                                transform="matrix(0.9723109602928162,0.17709478735923767,-0.17709478735923767,0.9723109602928162,0,0)">
                                                                <path fill="rgb(255,213,79)" fill-opacity="1"
                                                                    d=" M73.93099975585938,-6.883999824523926 C74.88200378417969,-6.291999816894531 75.1719970703125,-5.040999889373779 74.58000183105469,-4.090000152587891 C73.98799896240234,-3.1389999389648438 72.73699951171875,-2.8480000495910645 71.78600311279297,-3.440000057220459">
                                                                </path>
                                                            </g>
                                                            <g opacity="1"
                                                                transform="matrix(1,0,0,1,-6.715538024902344,-13.189847946166992)">
                                                                <path fill="rgb(255,213,79)" fill-opacity="1"
                                                                    d=" M69.44400024414062,41.17900085449219 C69.44400024414062,42.18000030517578 68.63200378417969,42.992000579833984 67.63099670410156,42.992000579833984 C66.62999725341797,42.992000579833984 65.81800079345703,42.18000030517578 65.81800079345703,41.17900085449219 C65.81800079345703,40.178001403808594 66.62999725341797,39.36600112915039 67.63099670410156,39.36600112915039 C68.63200378417969,39.36600112915039 69.44400024414062,40.178001403808594 69.44400024414062,41.17900085449219z">
                                                                </path>
                                                            </g>
                                                            <g opacity="1"
                                                                transform="matrix(1,0,0,1,-10.444656372070312,-37.06438446044922)">
                                                                <path fill="rgb(245,245,245)" fill-opacity="1"
                                                                    d=" M-53.305999755859375,27.448999404907227 C-53.305999755859375,28.450000762939453 -54.11800003051758,29.261999130249023 -55.11899948120117,29.261999130249023 C-56.119998931884766,29.261999130249023 -56.93199920654297,28.450000762939453 -56.93199920654297,27.448999404907227 C-56.93199920654297,26.447999954223633 -56.119998931884766,25.63599967956543 -55.11899948120117,25.63599967956543 C-54.11800003051758,25.63599967956543 -53.305999755859375,26.447999954223633 -53.305999755859375,27.448999404907227z">
                                                                </path>
                                                            </g>
                                                            <g opacity="1"
                                                                transform="matrix(0.8850853443145752,-0.45351219177246094,0.45351219177246094,0.8850853443145752,-2.132145643234253,0.12616348266601562)">
                                                                <path fill="rgb(52,168,83)" fill-opacity="1"
                                                                    d=" M-53.867000579833984,-20.260000228881836 C-53.867000579833984,-19.259000778198242 -54.67900085449219,-18.445999145507812 -55.68000030517578,-18.445999145507812 C-56.680999755859375,-18.445999145507812 -57.49300003051758,-19.259000778198242 -57.49300003051758,-20.260000228881836 C-57.49300003051758,-21.26099967956543 -56.680999755859375,-22.072999954223633 -55.68000030517578,-22.072999954223633 C-54.67900085449219,-22.072999954223633 -53.867000579833984,-21.26099967956543 -53.867000579833984,-20.260000228881836z M53.694000244140625,-25.40399932861328 C53.694000244140625,-24.402999877929688 52.88199996948242,-23.590999603271484 51.88100051879883,-23.590999603271484 C50.880001068115234,-23.590999603271484 50.06800079345703,-24.402999877929688 50.06800079345703,-25.40399932861328 C50.06800079345703,-26.405000686645508 50.880001068115234,-27.216999053955078 51.88100051879883,-27.216999053955078 C52.88199996948242,-27.216999053955078 53.694000244140625,-26.405000686645508 53.694000244140625,-25.40399932861328z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg></div>
                                    </div>
                                    <h4 class="mb-1">Your account is all set!</h4>
                                    <p>Now you can access to your account</p><a class="btn btn-primary px-5 my-3"
                                        href="../../modules/forms/wizard.html">Start Over</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="px-sm-3 px-md-5">
                                <ul class="pager wizard list-inline mb-0">
                                    <li class="previous"><button class="btn btn-link ps-0 d-none" type="button"><svg
                                                class="svg-inline--fa fa-chevron-left fa-w-10 me-2"
                                                data-fa-transform="shrink-3" aria-hidden="true" focusable="false"
                                                data-prefix="fas" data-icon="chevron-left" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;">
                                                <g transform="translate(160 256)">
                                                    <g
                                                        transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                        <path fill="currentColor"
                                                            d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"
                                                            transform="translate(-160 -256)"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <!-- <span class="fas fa-chevron-left me-2" data-fa-transform="shrink-3"></span> Font Awesome fontawesome.com -->Prev</button>
                                    </li>
                                    <li class="next"><button class="btn btn-primary px-5 px-sm-6" type="submit">Next<svg
                                                class="svg-inline--fa fa-chevron-right fa-w-10 ms-2"
                                                data-fa-transform="shrink-3" aria-hidden="true" focusable="false"
                                                data-prefix="fas" data-icon="chevron-right" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;">
                                                <g transform="translate(160 256)">
                                                    <g
                                                        transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                        <path fill="currentColor"
                                                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"
                                                            transform="translate(-160 -256)"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <!-- <span class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3"> </span> Font Awesome fontawesome.com --></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </x-www-uidemo>
