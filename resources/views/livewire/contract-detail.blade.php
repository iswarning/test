<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3"><x-jet-button wire:click="createShowContract"> Tạo hợp đồng </x-jet-button></div>
</div>
{{-- Thông tin Hợp đồng --}}
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h3>Thông tin hợp đồng</h3>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Mã lô giữ chỗ: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{$contract->lot_number}}</label>
        </div><hr/>

        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Trạng thái: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{$contract->status}}</label>
        </div><hr/>

        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Đã ký/ Chưa ký:: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">@if($contract->signed != 0) Đã ký @else Chưa ký @endif</label>
        </div><hr/>

        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Ngày ký: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{$contract->signed_date}}</label>
        </div><hr/>

        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Loại hợp đồng: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{$contract->type}}</label>
        </div><hr/>

        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Số hợp đồng: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{$contract->contract_no}}</label>
        </div><hr/>

        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Diện tích ký: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{$contract->area_signed}}</label>
        </div><hr/>

        <div class="row">
            <div class="col-md-1"></div>
            <h5 class="col-md-5"> Giá bán: </h5>
            <div class="col-md-1"></div>
            <label class="col-md-5">{{number_format($contract->value)}}</label>
        </div><hr/>

        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5"><x-jet-button wire:click="updateShowContract"> Sửa </x-jet-button></div>
        </div>

    </div>
</div>
<p></p>

{{-- Modal thêm + sửa thông tin hợp đồng --}}
<x-jet-dialog-modal wire:model="modalShowContractVisible">
    @if($this->contractId)
        <x-slot name="title">
            {{ __('Sửa hợp đồng') }}
        </x-slot>
    @else
        <x-slot name="title">
            {{ __('Thêm hợp đồng') }}
        </x-slot>
    @endif
    <x-slot name="content">
        <div class="row">
            <div class="col-md-6">
                <x-jet-label for="contract_no" value="{{ __('Mã hợp đồng') }}" />
                <x-jet-input id="contract_no" class="block mt-1 w-full" type="text" wire:model="contractData.contract_no" />
                @error('contractData.contract_no')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
            <div class="col-md-6">
                <x-jet-label for="type" value="{{ __('Loại hợp dồng') }}" />
                <x-jet-input id="type" class="block mt-1 w-full" type="text" wire:model="contractData.type" />
                @error('contractData.type')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <x-jet-label for="lot_number" value="{{ __('Mã lô') }}" />
                <x-jet-input id="lot_number" class="block mt-1 w-full" type="text" wire:model="contractData.lot_number" />
                @error('contractData.lot_number')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
            <div class="col-md-6">
                <x-jet-label for="area_signed" value="{{ __('Diện tích ký') }}" />
                <x-jet-input id="area_signed" class="block mt-1 w-full" type="text" wire:model="contractData.area_signed" />
                @error('contractData.area_signed')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Trạng thái</label>
                    </div>
                    <select class="custom-select" wire:model="contractData.status">

                    </select>
                </div>
                @error('contractData.status')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Dự án</label>
                    </div>
                    <select class="custom-select" wire:model="contractData.project_id">
                        <option value="0" selected>Chọn dự án</option>

                    </select>
                </div>
                @error('contractData.project_id')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-jet-label for="signed_date" value="{{ __('Ngày ký') }}" />
                <x-jet-input type="date" wire:model="contractData.signed_date" id="signed_date"/>
                @error('contractData.signed_date')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
            <div class="col-md-6">
                <x-jet-label for="signed_date" value="{{ __('Giá bán') }}" />
                <x-jet-input type="text" wire:model="contractData.value" id="value"/>
                @error('contractData.value')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
        </div>
        @if(!$this->contractId)
            <div class="row mt-4">
                <div class="col-md-6">
                    <x-jet-label for="payment_date_95" value="{{ __('Ngày thanh toán đủ 95%') }}" />
                    <x-jet-input type="date" wire:model="paymentData.payment_date_95" id="payment_date_95"/>
                </div>
                <div class="col-md-6">
                    <x-jet-label for="payment_progress" value="{{ __('Tiến độ thanh toán') }}" />
                    <x-jet-input type="text" wire:model="paymentData.payment_progress" id="payment_progress"/>
                </div>
            </div>
        @endif
        <div class="row mt-4">
            <div class="col-md-6 flex">
                <x-jet-label for="signed" value="{{ __('Đã ký / chưa ký') }}" />
                <input id="signed" type="checkbox" wire:model="contractData.signed" class="form-checkbox h-5 w-5 text-green-500 ml-2">
                @error('contractData.signed')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('modalShowContractVisible')" wire:loading.attr="disabled">
            {{ __('Hủy') }}
        </x-jet-secondary-button>

        @if($this->contractId)
            <x-jet-button class="ml-2" wire:click="updateContract" wire:loading.attr="disabled">
                {{ __('Cập nhật') }}
            </x-jet-button>
        @else
            <x-jet-button class="ml-2" wire:click="createContract" wire:loading.attr="disabled">
                {{ __('Lưu') }}
            </x-jet-button>
        @endif
    </x-slot>
</x-jet-dialog-modal>

