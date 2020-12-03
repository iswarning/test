<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Quản lý tài khoản
    </h2>
</x-slot>
<div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <h3>Danh sách khách hàng</h3>
                        </div> -->
                        <div class="card-body">
                            <div>
                                @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                                @endif
                            </div>
                            <div class="flex items-center justify-between mt-1 w-full">
                                <x-jet-input id="searchInput" class="block mt-1 w-50" type="text" name="searchInput" placeholder="Tìm kiếm" wire:model="keyWord" autofocus />
                                <x-jet-button wire:click="createShowModal"> {{ __('Thêm tài khoản') }} </x-jet-button>
                                <!-- Create and update customer modal -->
                                <x-jet-dialog-modal wire:model="modalFormVisible">
                                    <x-slot name="title">
                                        {{ __('Thêm tài khoản') }}
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-jet-label for="name" value="{{ __('Họ và tên') }}" />
                                                <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model.debounce.0ms="accountData.name" />
                                                @error('accountData.name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @endError
                                            </div>
                                            <div class="col-md-6">
                                                <x-jet-label for="email" value="{{ __('Email') }}" />
                                                <x-jet-input id="email" class="block mt-1 w-full" type="email" wire:model.debounce.0ms="accountData.email" />
                                                <br>
                                                @error('accountData.email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @endError
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <x-jet-label for="birthday" value="{{ __('Ngày sinh') }}" />
                                                <x-jet-input id="birthday" type="date" wire:model="accountData.birthday" />
                                                @error('accountData.birthday')
                                                <span class="text-danger">{{ $message }}</span>
                                                @endError
                                            </div>
                                            <div class="col-md-6">
                                                <x-jet-label for="password" value="{{ __('Mật Khẩu') }}" />
                                                <x-jet-input id="password" type="password" wire:model="accountData.password"/>
                                                @error('accountData.password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @endError
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="inputGroupSelect01">Phòng ban</label>
                                                    </div>
                                                    <select class="custom-select" wire:model="roleId">
                                                        <option value="0">Chọn phòng ban</option>
                                                        @foreach (App\Models\Role::all() as $role)
                                                        <option value="{{$role->id}}">{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="inputGroupSelect01">Vị trí</label>
                                                    </div>
                                                    <select class="custom-select" wire:model="permissionId">
                                                        <option value="0">Chọn vị trín</option>
                                                        @foreach ($permissions as $permission)
                                                        <option value="{{$permission->id}}">{{ $permission->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </x-slot>

                                    <x-slot name="footer">
                                        <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                                            {{ __('Hủy') }}
                                        </x-jet-secondary-button>

                                        @if ($accountId)
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
                            <br>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ và Tên</th>
                                        <th>Email</th>
                                        <th>Vị trí/Phòng Ban</th>
                                        <th>Ngày Sinh</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $account)
                                    <tr>
                                        <td>{{$account->id}}</td>
                                        <td>{{$account->name}}</td>
                                        <td>{{$account->email}}</td>
                                        <td>
                                            {{App\Models\Role::find($account->type)->name}}
                                            @if(App\Models\Permission::find($account->permission_id) != null)
                                                    - {{App\Models\Permission::find($account->permission_id)->name}}
                                                @endif
                                        </td>
                                        <td>{{$account->birthday}}</td>
                                        <td>
                                           
                                            <x-jet-button class="ml-2" wire:click="updateShowModal({{ $account->id }})"> {{ __('Sửa') }} </x-jet-button>
                                            
                                            @if($account->email != "admin@gmail.com" && $account->type != 1)
                                            <x-jet-button wire:click="deleteShowModal({{$account->id}})">{{ __('Xóa') }}</x-jet-button>
                                            @endif
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $accounts->links() }}
                            <x-jet-confirmation-modal wire:model="modalFormDeleteVisible">
                                <x-slot name="title">
                                    {{ __('Xóa tài khoản') }}
                                </x-slot>

                                <x-slot name="content">
                                    {{ __('Bạn có chắc muốn xóa thông tin tài khoản này?') }}
                                </x-slot>

                                <x-slot name="footer">
                                    <x-jet-secondary-button wire:click="$toggle('modalFormDeleteVisible')" wire:loading.attr="disabled">
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
<!-- Confirm delete customer modal -->
<!-- <x-jet-confirmation-modal wire:model="modalConfirmDeleteVisible">
    <x-slot name="title">
        {{ __('Xóa thông tin khách hàng') }}
    </x-slot>

    <x-slot name="content">
        {{ __('Bạn có chắc muốn xóa thông tin khách hàng này?') }}
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
            {{ __('Hủy') }}
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
            {{ __('Xóa') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-confirmation-modal> -->
