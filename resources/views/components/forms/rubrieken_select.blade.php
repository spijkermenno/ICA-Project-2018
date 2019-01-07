<div class="form-group">
    <label for="categories">Kies een hoofdrubriek</label>
    <select class="form-control {{ $errors->has("category_id") ? " is-invalid" : "" }}"
            onchange="removeAllChildren(); retrieveNewSubrubriek(this.options[this.selectedIndex].value); "
            id="categories">
        <option selected disabled>Rubriek</option>
        @foreach($auction_rubrieken as $rubriek)
            <option value="{{$rubriek->id}}">{{$rubriek->name}}</option>
        @endforeach
    </select>
    @include('components.forms.error', ['key' => 'category_id'])
    <div id="select-boxes">

    </div>

</div>
<script>
    function removeAllChildren() {
        const node = document.getElementById('select-boxes');
        while (node.firstChild) {
            node.removeChild(node.firstChild);
        }
    }

    function retrieveNewSubrubriek(id) {
        axios.get(`/api/category/children/${id}`)
            .then(function (response) {
                document.getElementById('select-boxes').insertAdjacentHTML('beforeend', response.data);
            })
    }
</script>
