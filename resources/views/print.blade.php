<div class="card">
    <div class="card-header">Thông tin khách hàng</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Họ và Tên: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{$customerData}}</label>
        </div><hr/>
        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> CMND: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{$customerData['cmnd']}}</label>
        </div><hr/>

        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Địa Chỉ: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{$customerData['address']}}</label>
        </div><hr/>

        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Hộ Khẩu: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{$customerData['household']}}</label>
        </div><hr/>

        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Ngày Sinh: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{$customerData['birthday']}}</label>
        </div><hr/>

        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Số điện thoại: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{$customerData['phone']}}</label>
        </div><hr/>
    </div>
</div>