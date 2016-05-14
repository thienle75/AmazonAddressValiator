<form name="civicAddress" method="post" action="{{ $action }}">
    <div class="row">
        <div class="col-lg-12">
            <input type="hidden" name="type" value="civic">
            <label for="name">Address Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. My Address">
            <label for="street_number">Street Number</label>
            <input type="text" name="street_number" class="form-control" placeholder="e.g. 123">
            <label for="street_name">Street Name</label>
            <input type="text" name="street_name" class="form-control" placeholder="e.g. Main">
            <label for="street_type">Street Type</label>
            <input type="text" name="street_type" class="form-control" placeholder="e.g. Street">
            <label for="street_direction">Street Direction</label>
            <input type="text" name="street_direction" class="form-control" placeholder="e.g. West">
            <label for="city">City</label>
            <input type="text" name="city" class="form-control" placeholder="e.g. Toronto">
            <label for="province">Province</label>
            <input type="text" name="province" class="form-control" placeholder="e.g. ON">
            <label for="postal_code">Postal Code</label>
            <input type="text" name="postal_code" class="form-control" placeholder="e.g. A1A 1A1">
            <label for="country">Country</label>
            <input type="text" name="country" class="form-control" placeholder="e.g. CA">
            <label for="suite">Suite</label>
            <input type="text" name="suite" class="form-control" placeholder="e.g. Apt. 1">
            <label for="buzzer">Buzzer</label>
            <input type="text" name="buzzer" class="form-control" placeholder="e.g. Buzzer 123">
        </div>
    </div>
</form>