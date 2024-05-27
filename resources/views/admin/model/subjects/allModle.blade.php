<div class="infoModle">
    {{-- @foreach ($subjects as $subject)
        <div id="InfoSubject{{ $subject->id }}" class=" hidden fixed z-10 inset-0 overflow-y-auto "
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            @include('admin.model.subjects.infoSubject')
        </div>
    @endforeach --}}
</div>
<div class="editModle">
    {{-- @foreach ($subjects as $subject)
        <div id="EditSubject{{ $subject->id }}" class=" hidden fixed z-10 inset-0 overflow-y-auto "
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            @include('admin.model.subjects.editSubject')
        </div>
    @endforeach --}}
</div>
<div class="deleteModle">
    {{-- @foreach ($subjects as $subject)
        <div id="DeleteSubject{{ $subject->id }}" class="hidden fixed z-10 inset-0 overflow-y-auto "
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            @include('admin.model.subjects.deleteSubject')
        </div>
    @endforeach --}}
</div>
<div class="editModleSubjectUser">

    {{-- @foreach ($subjects as $subject)
        <div class="editSubjectUserModle_{{ $subject->id }}">
            @foreach ($subject->users as $subjectUser)
                <div id="EditSubjectUser_{{ $subject->id }}_{{ $subjectUser->id }}"
                    class="hidden fixed z-10 inset-0 overflow-y-auto " aria-labelledby="modal-title" role="dialog"
                    aria-modal="true">
                    @include('admin.model.subjects.editSubjectUser')
                </div>
            @endforeach
        </div>
    @endforeach --}}
</div>
<div class="deleteModleSubjectUser">
    {{-- @foreach ($subjects as $subject)
        <div class="deleteSubjectUserModle_{{ $subject->id }}">
            @foreach ($subject->users as $subjectUser)
                <div id="DeleteSubjectUser_{{ $subject->id }}_{{ $subjectUser->id }}"
                    class="hidden fixed z-10 inset-0 overflow-y-auto " aria-labelledby="modal-title" role="dialog"
                    aria-modal="true">
                    @include('admin.model.subjects.deleteSubjectUser')
                </div>
            @endforeach
        </div>
    @endforeach --}}
</div>

<div class="createSubjectUserModle">
    {{-- @foreach ($subjects as $subject)
        <div id="CreateSubjectUser{{ $subject->id }}" class=" hidden fixed z-10 inset-0 overflow-y-auto "
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            @include('admin.model.subjects.createSubjectUser')
        </div>
    @endforeach --}}
</div>
<div id="CreatSubject" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    @include('admin.model.subjects.createSubject')
</div>
