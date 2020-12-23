<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Thông tin chi tiết khách hàng {{ App\Models\Customers::find($customerId)->name }}
        </h2>
    </x-slot>

    <div>
        <section>
        
            <div class="container">
                <p></p>
                <div>
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                <p></p>
                <div class="container">
                    @if(Auth::user()->type != 3)
                    <div class="row">
                        <div class="col-md-7"></div>
                        <div class="col-md-2">
                            
                        </div>
                        <div class="col-md-3">
                            
                            @livewire('contract-create', ['customerId' => $customerId])
                        </div>
                    </div>
                    @endif
                    {{-- Modal thêm + sửa thông tin hợp đồng --}}
                    
                    
                </div>
    
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#customer" role="tab" aria-controls="customer" aria-selected="true">Thông tin</a>
                    </li>
                    @foreach($contracts as $key => $item)
                        <li class="nav-item">
                            <a class="nav-link " href="#contract{{ $item->id }}" id="contract-tab-{{ $item->id }}" data-toggle="tab" role="tab" aria-controls="contract" aria-selected="true">Hợp đồng {{$item->contract_no}}</a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                        @livewire('customer-detail', ['id'=>$customerId])
                    </div>
                    
                    @foreach($contracts as $key => $row)
                        {{-- @if($tab == 'contract'.$key.'') --}}
                            <div class="tab-pane fade" id="contract{{ $row->id }}" role="tabpanel" aria-labelledby="contract-tab-{{ $row->id }}">
                                @livewire('contract-component', ['id'=>$row->id] , key($key))

                                @livewire('payment-component', ['id'=>$row->id], key($key))

                                @livewire('juridical-component', ['id'=>$row->id], key($key))               
                            </div>
                        {{-- @endif --}}
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    <script>

        ( function( factory ) {
                if ( typeof define === "function" && define.amd ) {
    
                    // AMD. Register as an anonymous module.
                    define( [ "../widgets/datepicker" ], factory );
                } else {
    
                    // Browser globals
                    factory( jQuery.datepicker );
                }
            }( function( datepicker ) {
    
                datepicker.regional.vi = {
                    changeYear: true,
                    changeMonth: true,
                    
                    yearRange: '+0:+2',
                    closeText: "Đóng",
                    prevText: "&#x3C;Trước",
                    nextText: "Tiếp&#x3E;",
                    currentText: "Hôm nay",
                    monthNames: [ "Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
                    "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai" ],
                    monthNamesShort: [ "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                    "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12" ],
                    dayNames: [ "Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy" ],
                    dayNamesShort: [ "CN", "T2", "T3", "T4", "T5", "T6", "T7" ],
                    dayNamesMin: [ "CN", "T2", "T3", "T4", "T5", "T6", "T7" ],
                    weekHeader: "Tu",
                    dateFormat: "yy-mm-dd",
                    firstDay: 0,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: "" ,
                    // showOn: "both",
                    // buttonImageOnly: true,
                    // buttonImage: "calendar.gif",
                    // buttonText: "Calendar"
                };
                
                
                datepicker.setDefaults( datepicker.regional.vi );
    
                return datepicker.regional.vi;
    
            } ) );
    
    
    
    </script>
</x-app-layout>
