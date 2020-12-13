<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Quản lý dự án
    </h2>
</x-slot>
<div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h3>Danh sách dự án</h3>
                                </div>
                                <div class="col-md-2"></div>
                                @if(Auth::user()->type != 3)
                                <div class="col-md-2"><x-jet-button wire:click="createShowModal"> {{ __('Thêm dự án') }} </x-jet-button></div>
                                @endif
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="flex items-center justify-between mt-1 w-full">

                                <x-jet-dialog-modal wire:model="modalShowProjectVisible">
                                    <x-slot name="title">
                                        {{ __('Thêm dự án') }}
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-jet-label for="name" value="{{ __('Tên dự án') }}" />
                                                <x-jet-input autocomplete="off" id="name" class="block mt-1 w-full" type="text" wire:model.debounce.0ms="projectData.name" />
                                                @error('projectData.name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @endError
                                            </div>
                                            <div class="col-md-6">
                                                <x-jet-label for="description" value="{{ __('Mô tả dự án') }}" />
                                                <x-jet-input autocomplete="off" id="description" class="block mt-1 w-full" type="text" wire:model.debounce.0ms="projectData.description" />
                                                <br>
                                                @error('projectData.description')
                                                <span class="text-danger">{{ $message }}</span>
                                                @endError
                                            </div>
                                        </div>

                                    </x-slot>

                                    <x-slot name="footer">
                                        <x-jet-secondary-button wire:click="$toggle('modalShowProjectVisible')" wire:loading.attr="disabled">
                                            {{ __('Hủy') }}
                                        </x-jet-secondary-button>



                                        @if($projectID)
                                            <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                                                {{ __('Cập nhật') }}
                                            </x-jet-button>
                                        @else
                                            <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                                                {{ __('Lưu') }}
                                            </x-jet-button>
                                        @endif

                                    </x-slot>
                                </x-jet-dialog-modal>
                            </div>
                                <table class="table table-striped" wire:model="dataTableProjectVisible">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên dự án</th>
                                    <th>Mô tả dự án</th>
                                    @if(Auth::user()->type != 3)
                                    <th class="text-center">Sửa</th>
                                    <th class="text-center">Xóa</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($projects as $project)
                                    <tr>
                                        <td>{{$project['id']}}</td>
                                        <td>{{$project['name']}}</td>
                                        <td>{{$project['description']}}</td>
                                        @if(Auth::user()->type != 3)
                                        <td class="text-center"><x-jet-button class="ml-2" wire:click="updateShowModal({{ $project['id']}})"> {{ __('Sửa') }} </x-jet-button></td>
                                        <td class="text-center"><x-jet-button class="ml-2" wire:click="confirmDelete({{$project['id']}})"> {{ __('Xóa') }} </x-jet-button></td>
                                        @endif
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                            <x-jet-confirmation-modal wire:model="confirmDeleteVisible">
                                <x-slot name="title">
                                    {{ __('Xóa thông tin dự án') }}
                                </x-slot>

                                <x-slot name="content">
                                    {{ __('Bạn có chắc muốn xóa thông tin dự án này?') }}<br>
                                    <span class='text-red-600'>{{ __('Nếu xóa thông tin dự án thì tất cả thông tin hợp đồng liên quan đến dự án sẽ bị xóa sạch !!!') }}</span>
                                </x-slot>

                                <x-slot name="footer">
                                    <x-jet-secondary-button wire:click="$toggle('confirmDeleteVisible')" wire:loading.attr="disabled">
                                        {{ __('Hủy') }}
                                    </x-jet-secondary-button>

                                    <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                                        {{ __('Xóa') }}
                                    </x-jet-danger-button>
                                </x-slot>
                            </x-jet-confirmation-modal>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </section>
</div>
