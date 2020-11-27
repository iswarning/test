<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Thông tin chi tiết hợp đồng 
     </h2>
</x-slot>
<div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        <h3>Thông tin hợp đồng</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Mã lô giữ chỗ: </td>
                                        <td>{{$contract->lot_number}}</td>
                                    </tr>
                                    <tr>
                                        <td>Trạng thái: </td>
                                        <td>
                                            @php 
                                                $status = App\Models\ContractStatus::find($contract->status);
                                                if($status == null){$name = "";}else{$name = $status->name;}                                                
                                            @endphp
                                            @if($name === "Trả giữ chỗ" or $name === "Bỏ giữ chỗ")
                                                - {{$contract->status_created_by}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Đã ký/ chưa ký: </td>
                                        <td>@if($contract->signed != 0) Đã ký @else Chưa ký @endif</td>
                                    </tr>
                                    <tr>
                                        <td>Ngày ký: </td>
                                        <td>{{$contract->signed_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Loại hợp đồng: </td>
                                        <td>{{$contract->type}}</td>
                                    </tr>
                                    <tr>
                                        <td>Số hợp đồng: </td>
                                        <td>{{$contract->contract_no}}</td>
                                    </tr>
                                    <tr>
                                        <td>Diện tích ký: </td>
                                        <td>{{$contract->area_signed}}</td>
                                    </tr>
                                    <tr>
                                        <td>Giá bán: </td>
                                        <td>{{number_format($contract->value)}}</td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($this->paymentData != null)
                    <div class="card">
                        <div class="card-header">
                        <h3>Thông tin thanh toán</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Tiến độ thanh toán: </td>
                                        <td>{{$this->paymentData->payment_progress}}</td>
                                    </tr>
                                    <tr>
                                        <td>Ngày thanh toán đủ 95%: </td>
                                        <td>{{$this->paymentData->payment_date_95}}</td>
                                    </tr>
                                    <tr>
                                        <td>Ngày trễ: </td>
                                        <td>{{$this->paymentData->day_late}}</td>
                                    </tr>
                                    <tr>
                                        <td>Đợt trễ: </td>
                                        <td>{{$this->paymentData->batch_late}}</td>
                                    </tr>
                                    <tr>
                                        <td>Số tiền trễ: </td>
                                        <td>{{$this->paymentData->money_late}}</td>
                                    </tr>
                                    <tr>
                                        <td>Lãi phạt: </td>
                                        <td>{{$this->paymentData->citation_rate}}</td>
                                    </tr>
                                    <tr>
                                        <td>Số lần đã gửi thông báo: </td>
                                        <td>{{$this->paymentData->number_notifi}}</td>
                                    </tr>
                                    <tr>
                                        <td>Văn bản, phương thức: </td>
                                        <td>{{$this->paymentData->document}}</td>
                                    </tr>
                                    <tr>
                                        <td>Ngày khách nhận thông báo: </td>
                                        <td>{{$this->paymentData->receipt_date}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                        <br>
                        <x-jet-button wire:click="createShowModalPayment">{{ __('Thêm thông tin thanh toán') }}</x-jet-button>
                        <x-jet-dialog-modal wire:model="modalFormCustomerVisible">
                            <x-slot name="title">
                                {{ __('Thêm thông tin thanh toán') }}
                            </x-slot>

                            <x-slot name="content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-jet-label for="name" value="{{ __('Họ tên') }}" />
                                        <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model.debounce.0ms="customerData.name" />
                                        @error('customerData.name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="cmnd" value="{{ __('Chứng minh nhân dân') }}" />
                                        <x-jet-input id="cmnd" class="block mt-1 w-full" type="text" wire:model.debounce.0ms="customerData.cmnd" />
                                        <br>
                                        @error('customerData.cmnd')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="birthday" value="{{ __('Ngày sinh') }}" />
                                        <x-jet-input id="birthday" type="date" wire:model="customerData.birthday" />
                                        @error('customerData.birthday')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="phone" value="{{ __('Số điện thoại') }}" />
                                        <x-jet-input id="phone" type="text" wire:model="customerData.phone" />
                                        @error('customerData.phone')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="household" value="{{ __('Hộ khẩu thường trú') }}" />
                                        <x-jet-input id="household" type="text" wire:model="customerData.household" />
                                        <br>
                                        @error('customerData.household')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="address" value="{{ __('Địa chỉ liên hệ') }}" />
                                        <x-jet-input id="address" type="text" wire:model="customerData.address" />
                                        <br>
                                        @error('customerData.address')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                            </x-slot>
                        
                            <x-slot name="footer">
                                <x-jet-secondary-button wire:click="$toggle('modalFormCustomerVisible')" wire:loading.attr="disabled">
                                    {{ __('Hủy') }}
                                </x-jet-secondary-button>

                                <x-jet-button class="ml-2" wire:click="nextModal" wire:loading.attr="disabled">
                                    {{ __('Tiếp theo') }}
                                </x-jet-button>
                                
                            </x-slot>
                        </x-jet-dialog-modal>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
