<div role="tabpanel" class="tab-pane " id="administration-tab">
    <h3 class="title">Administration</h3>
    <div class="section ">
        <p>Please enter your account details for administration.</p>
        <hr />
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-2">
                    <label for="first_name">First Name</label>
                    <input type="text" value="{{ old('first_name') ?? '' }}" id="first_name" name="first_name"
                        class="form-control form--control" placeholder="Your first name" />
                </div>
            </div>
            <div class=" col-md-6">
                <div class="form-group  mt-2">
                    <label for="last_name">Last Name</label>
                    <input type="text" value="{{ old('last_name') ?? '' }}" id="last_name" name="last_name"
                        class="form-control  form--control" placeholder="Your last name" />
                </div>
            </div>
            <div class=" col-md-6">
                <div class="form-group  mt-2">
                    <label for="email">Email</label>
                    <input type="text" value="{{ old('email') ?? '' }}" name="email"
                        class="form-control  form--control" placeholder="Your email" />
                </div>
            </div>
            <div class=" col-md-6">
                <div class="form-group  mt-2">
                    <label for="password">Login Password</label>
                    <input type="password" value="{{ old('password') ?? '' }}" name="password"
                        class="form-control  form--control" placeholder="Login password" />
                </div>
            </div>
            <div class=" col-md-12">
                <div class="form-group  mt-2">
                    <label for="password">Purchase code</label>
                    <input type="text" value="{{ old('purchase_code') ?? '' }}" name="purchase_code"
                        class="form-control  form--control" placeholder="Enter your purchase code" />
                </div>
            </div>

        </div>
    </div>
    <div class="d-flex justify-content-between mt-5">
        <button class="btn btn-primary previous" type="button"><i class='fa fa-arrow-left'></i> Preview</button>
        <button class="btn btn-primary " type="submit"> Finish</button>
    </div>
</div>
