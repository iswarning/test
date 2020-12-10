
<x-jet-button wire:click="$emit('createShowModalContract')">Tạo Hợp Đồng</x-jet-button>
<x-jet-dialog-modal wire:model="modalShowContractVisible">

    <x-slot name="title">
        {{ __('Thêm hợp đồng') }}
    </x-slot>

    <x-slot name="content">
        <div class="row">
            <div class="col-md-6">
                <x-jet-label for="contract_no" value="{{ __('Số hợp đồng') }}" />
                <x-jet-input id="contract_no" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.contract_no" autocomplete="off"/>
                @error('contractData.contract_no')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
            <div class="col-md-6">
                <x-jet-label for="type" value="{{ __('Loại hợp đồng') }}" />
                <x-jet-input id="type" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.type" autocomplete="off"/>
                @error('contractData.type')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <x-jet-label for="lot_number" value="{{ __('Mã lô') }}" />
                <x-jet-input id="lot_number" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.lot_number" autocomplete="off"/>
                @error('contractData.lot_number')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
            <div class="col-md-6">
                <x-jet-label for="area_signed" value="{{ __('Diện tích ký') }}" />
                <x-jet-input id="area_signed" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.area_signed" autocomplete="off"/>
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
                    <select class="custom-select" wire:model.lazy="contractData.status">
                        <option>Chọn trạng thái</option>
                        @foreach ($contractStatus as $status)
                            <option value="{{$loop->index}}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                @error('contractData.status')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
            
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Giữ chỗ</label>
                    </div>
                    <select class="custom-select" wire:model.lazy="contractData.status_created_by">
                        <option>Chọn giữ chỗ</option>
                        @foreach($contractStatusCreated as $item)
                            <option value="{{$loop->index}}">{{$item}}</option>
                        @endforeach
                    </select>
                </div>
                @error('contractData.status_created_by')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <x-jet-label for="signed_date" value="{{ __('Ngày ký') }}" />
                <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="contractData.signed_date" id="signed_date" placeholder="Chọn ngày ký..." autocomplete="off"/>
                @error('contractData.signed_date')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
            <div class="col-md-6">
                <x-jet-label for="signed_date" value="{{ __('Giá bán') }}" />
                <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="contractData.value" id="value" autocomplete="off"/>
                @error('contractData.value')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <x-jet-label for="payment_date_95" value="{{ __('Ngày thanh toán đủ 95%') }}" />
                <x-jet-input type="text" class="block mt-1 w-full" wire:model="payment_date_95" id="payment_date_95" placeholder="Chọn ngày thanh toán..." autocomplete='off'/>
                
            </div>
            <div class="col-md-6">
                <x-jet-label for="payment_progress" value="{{ __('Tiến độ thanh toán') }}" /> 
                <x-jet-input type="text" class="block mt-1 w-full" wire:model="payment_progress" id="payment_progress" autocomplete="off"/>
                @error('payment_progress')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
        </div>
        

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Dự án</label>
                    </div>
                    <select class="custom-select" wire:model.lazy="contractData.project_id">
                        <option value="0" selected>Chọn dự án</option>
                        @foreach($projects as $project)
                            <option value="{{$project->id}}">{{$project->name}}</option>
                        @endforeach
                    </select>
                </div>
                @error('contractData.project_id')
                <span class="text-danger">{{ $message }}</span>
                @endError
            </div>
            <div class="col-md-6 flex">
                <x-jet-label for="signed" value="{{ __('Đã ký / chưa ký') }}" />
                <input id="signed" type="checkbox" wire:model.lazy="contractData.signed" class="form-checkbox h-5 w-5 text-green-500 ml-2 " autocomplete="off">
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

            <x-jet-button class="ml-2" wire:click="createContract" wire:loading.attr="disabled">
                {{ __('Lưu') }}
            </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>

<x-jet-button data-toggle="modal" data-target="#exampleModal">
	Tạo Hợp Đồng
</x-jet-button>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Thêm hợp đồng') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <x-jet-label for="contract_no" value="{{ __('Số hợp đồng') }}" />
                    <x-jet-input id="contract_no" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.contract_no" autocomplete="off"/>
                    @error('contractData.contract_no')
                    <span class="text-danger">{{ $message }}</span>
                    @endError
                </div>
                <div class="col-md-6">
                    <x-jet-label for="type" value="{{ __('Loại hợp đồng') }}" />
                    <x-jet-input id="type" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.type" autocomplete="off"/>
                    @error('contractData.type')
                    <span class="text-danger">{{ $message }}</span>
                    @endError
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <x-jet-label for="lot_number" value="{{ __('Mã lô') }}" />
                    <x-jet-input id="lot_number" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.lot_number" autocomplete="off"/>
                    @error('contractData.lot_number')
                    <span class="text-danger">{{ $message }}</span>
                    @endError
                </div>
                <div class="col-md-6">
                    <x-jet-label for="area_signed" value="{{ __('Diện tích ký') }}" />
                    <x-jet-input id="area_signed" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.area_signed" autocomplete="off"/>
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
                        <select class="custom-select" wire:model.lazy="contractData.status">
                            <option>Chọn trạng thái</option>
                            @foreach ($contractStatus as $status)
                                <option value="{{$loop->index}}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('contractData.status')
                    <span class="text-danger">{{ $message }}</span>
                    @endError
                </div>
                
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Giữ chỗ</label>
                        </div>
                        <select class="custom-select" wire:model.lazy="contractData.status_created_by">
                            <option>Chọn giữ chỗ</option>
                            @foreach($contractStatusCreated as $item)
                                <option value="{{$loop->index}}">{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('contractData.status_created_by')
                    <span class="text-danger">{{ $message }}</span>
                    @endError
                </div>
    
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-jet-label for="signed_date" value="{{ __('Ngày ký') }}" />
                    <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="contractData.signed_date" id="signed_date" placeholder="Chọn ngày ký..." autocomplete="off"/>
                    @error('contractData.signed_date')
                    <span class="text-danger">{{ $message }}</span>
                    @endError
                </div>
                <div class="col-md-6">
                    <x-jet-label for="signed_date" value="{{ __('Giá bán') }}" />
                    <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="contractData.value" id="value" autocomplete="off"/>
                    @error('contractData.value')
                    <span class="text-danger">{{ $message }}</span>
                    @endError
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <x-jet-label for="payment_date_95" value="{{ __('Ngày thanh toán đủ 95%') }}" />
                    <x-jet-input type="text" class="block mt-1 w-full" wire:model="payment_date_95" id="payment_date_95" placeholder="Chọn ngày thanh toán..." autocomplete='off'/>
                    
                </div>
                <div class="col-md-6">
                    <x-jet-label for="payment_progress" value="{{ __('Tiến độ thanh toán') }}" /> 
                    <x-jet-input type="text" class="block mt-1 w-full" wire:model="payment_progress" id="payment_progress" autocomplete="off"/>
                    @error('payment_progress')
                    <span class="text-danger">{{ $message }}</span>
                    @endError
                </div>
            </div>
            
    
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Dự án</label>
                        </div>
                        <select class="custom-select" wire:model.lazy="contractData.project_id">
                            <option value="0" selected>Chọn dự án</option>
                            @foreach($projects as $project)
                                <option value="{{$project->id}}">{{$project->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('contractData.project_id')
                    <span class="text-danger">{{ $message }}</span>
                    @endError
                </div>
                <div class="col-md-6 flex">
                    <x-jet-label for="signed" value="{{ __('Đã ký / chưa ký') }}" />
                    <input id="signed" type="checkbox" wire:model.lazy="contractData.signed" class="form-checkbox h-5 w-5 text-green-500 ml-2 " autocomplete="off">
                    @error('contractData.signed')
                    <span class="text-danger">{{ $message }}</span>
                    @endError
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <x-jet-secondary-button data-dismiss="modal">Close</x-jet-secondary-button>
                <x-jet-button wire:click.prevent="store()" class="btn btn-primary close-modal">Save changes</x-jet-button>
            </div>
        </div>
    </div>
</div>