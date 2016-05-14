<form name="civicAddress" method="post" action="{{ $action }}">
    <div class="row">
        <div class="col-lg-12">
            <input type="hidden" name="type" value="civic">
            <label for="name">Address Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. My Address">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" placeholder="e.g. 123 Main Street West Apt. 2">
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