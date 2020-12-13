<?php

namespace App\Http\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Project;

class Projects extends Component
{
    public $projectID;
    public $modalShowProjectVisible = false;
    public $confirmDeleteVisible = false;
    public $projectData = [];
    

    public function rules()
    {
        return [
            'projectData.name' => ['required','unique' => Rule::unique('projects', 'name')->ignore($this->projectID)] ,
            'projectData.description' => 'required' ,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'required' ,
            'name.unique' => 'Tên dự án đã tồn tại' ,
            'description.required' => 'required' ,
        ];
    }

    public function createShowModal()
    {
        $this->reset();
        $this->modalShowProjectVisible = true;
    }

    public function create()
    {
        $this->validate();
        Project::create($this->projectData);
        $this->modalShowProjectVisible = false;
        session()->flash('message', 'Thêm dự án thành công');
    }

    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->projectID = $id;
        $this->projectData = Project::find($this->projectID)->toArray();
        $this->modalShowProjectVisible = true;
    }

    public function update()
    {
        $this->validate();
        Project::find($this->projectID)->update($this->projectData);
        $this->modalShowProjectVisible = false;
        session()->flash('message', 'Cập nhật dự án thành công');
    }

    public function confirmDelete($id)
    {
        $this->projectID = $id;
        $this->confirmDeleteVisible = true;
    }

    public function delete()
    {
        Project::find($this->projectID)->delete();
        $this->confirmDeleteVisible = false;
        session()->flash('message', 'Xóa dự án thành công');
    }

    public function render()
    {
        return view('livewire.projects', [
            'projects' => Project::all()
        ]);
    }
}
