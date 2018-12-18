<div class="col-lg-6 col-md-6 col-sm-12">
    <div class="row">
        <div class="col-12">
            <h3 class="word-break"> {{$product->title}}</h3>
            <hr/>
        </div>
        <div class="col-12">
            <iframe src="/api/productDescriptionIFrame/{{$product->id}}" style="width: 100%; height: 100vh; border: none;">

            </iframe>
        </div>
    </div>
</div>
