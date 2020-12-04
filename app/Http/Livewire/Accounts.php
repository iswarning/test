<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User as ModelsAccount;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\type;

class Accounts extends Component
{
    public $accountId;
    public $keyWord;
    public $recordNum = 20;
    public $roleId = 0;
    public $permissionId = 1;
    public $modalFormVisible = false;
    public $modalFormDeleteVisible = false;
    public $accountData = [];
    protected $paginationTheme = 'bootstrap';
    public $dataNotUpdate;
    public $dataUpdated;

    public function rules()
    {
        return [
            'accountData.name' => 'required',
            'accountData.email' => ['required',
                Rule::unique('users', 'email')->ignore($this->accountId),
                'email'] ,

            'accountData.password' => 'required|min:6',
            'accountData.birthday' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'accountData.name.required' => 'Không thể để trống họ tên',
            'accountData.email.required' => 'Không thể để trống tên đăng nhập',
            'accountData.email.email' => 'Email không hợp lệ',
            'accountData.email.unique' => 'Email đã tồn tại',
            'accountData.password.required' => 'Không thể để trống mật khẩu',
            'accountData.password.min' => 'Mật khẩu có ít nhất 6 ký tự',
            'accountData.birthday.required' => 'Không thể để trống ngày sinh',
        ];
    }



    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function create()
    {
        $this->validate();
        $this->accountData['type'] = $this->roleId;
        $this->accountData['permission_id'] = $this->permissionId;
        $this->accountData['password'] = bcrypt($this->accountData['password']);
        ModelsAccount::create($this->accountData);
        $this->modalFormVisible = false;
        session()->flash('message', 'Tạo tài khoản thành công');
    }

    public function createShowModal()
    {
        $this->reset();
        $this->modalFormVisible = true;
    }

    public function update()
    {
        $this->validate();
        $this->accountData['type'] = $this->roleId;
        $this->accountData['permission_id'] = $this->permissionId;
        ModelsAccount::find($this->accountId)->update($this->accountData);
        $this->modalFormVisible = false;
        $this->dataUpdated = ModelsAccount::find($this->accountId);


        session()->flash('message', 'Cập nhật tài khoản thành công');
    }


    public function updateShowModal($id)
    {
        $this->dataNotUpdate = ModelsAccount::findOrFail($id);
        $this->resetValidation();
        $this->accountId = $id;
        $this->modalFormVisible  = true;
        $this->accountData = ModelsAccount::findOrFail($this->accountId)->toArray();
        $this->roleId = $this->accountData['type'];
        $this->permissionId = $this->accountData['permission_id'];
    }

    public function delete()
    {
        $user = ModelsAccount::findOrFail($this->accountId);
        $user->delete();
        $this->modalFormDeleteVisible = false;
        $this->reset();
        session()->flash('message', 'Xóa tài khoản thành công');
    }

    public function deleteShowModal($id)
    {
        $this->accountId = $id;
        $this->modalFormDeleteVisible = true;
    }

    public function render()
    {

        $searchKey = '%'. $this->keyWord .'%';
        return view('livewire.accounts', [
            'accounts' => ModelsAccount::where(function ($sub_query) use ($searchKey){
                $sub_query->where('name', 'like', $searchKey)
                    ->orWhere('email', 'like', $searchKey)
                    ->orWhere('password', 'like', $searchKey)
                    ->orWhere('type', 'like', $searchKey)
                    ->orWhere('birthday', 'like', $searchKey);
            })->paginate($this->recordNum) ,

            'roles' => Role::all() ,
            'permissions' => Permission::where('role_id',$this->roleId)->get()
        ]);
    }
}
