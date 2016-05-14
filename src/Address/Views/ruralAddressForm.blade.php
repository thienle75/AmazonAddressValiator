<form name="civicAddress" method="post" action="{{ $action }}">
    <div class="row">
        <div class="col-lg-12">
            <input type="hidden" name="type" value="civic">
            <label for="name">Address Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. My Address">
            <label for="street_number">Rural Route</label>
            <input type="text" name="rural_route" class="form-control" placeholder="e.g. RR 40123">
            <label for="street_name">Station</label>
            <input type="text" name="station" class="form-control" placeholder="e.g. STN A">
            <label for="city">City</label>
            <input type="text" name="city" class="form-control" placeholder="e.g. Toronto">
            <label for="province">Province</label>
            <input type="text" name="province" class="form-control" placeholder="e.g. ON">
            <label for="postal_code">Postal Code</label>
            <input type="text" name="postal_code" class="form-control" placeholder="e.g. A1A 1A1">
            <label for="country">Country</label>
            <input type="text" name="country" class="form-control" placeholder="e.g. CA">
        </div>
    </div>
</form>