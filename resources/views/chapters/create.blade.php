@extends('layouts.admin')
@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Upload Chapter') }}</h1>
    <a href="{{ route('books.show', $book) }}" class="btn btn-primary btn-sm mb-2"><i class="fa fa-angle-left"></i> Back</a>
    @include('partials.alert')
    <form action="{{ route('books.chapters.store', $book) }}" method="POST" enctype="multipart/form-data" x-data="{
        mode:'chapter',
        typeChapter:'regular',
        updateTypeChapter(){
            let ctselector = document.getElementById('chapter_type');
            this.typeChapter = ctselector.value;
        },
        updateMode(){
            this.mode = document.getElementById('mode').value;
        }
    }">
        @csrf
        <x-form.group>
           <x-form.select
        label="Chapter | Prologue | Epilogue"
        name="mode"
        :options="[
            [
                'value'=>'chapter',
                'label'=>'Chapter'
            ],
            [
                'value'=>'prologue',
                'label'=>'Prologue'
            ],
            [
                'value'=>'epilogue',
                'label'=>'Epilogue'
            ]
        ]"/>
        </select>

        </x-form.group>
        <template x-if="mode == 'chapter'">
            <div>
                <div class="form-group">
                    <label for="#">Title</label>
                    <input type="text" class="form-control" name="title"  value="{{ old('title') }}">
                </div>
                <div class="form-group">
                    <label for="#">Chapter <small><i>Last Chapter {{ $book->lastchapter }}</i></small></label>
                    <input type="text" class="form-control" name="sq"  required value="{{ old('sq') ?? $book->lastchapter+1 }}">
                </div>
            </div>
        </template>
        
       <x-form.group>
            <x-form.label>Choose PDF</x-form.label>
           <x-form.file name="chapter_content" label="" accept="application/pdf" required/>
       </x-form.group>

       <x-form.group>
           <label for="">
                Type
            </label>
            <select name="chapter_type" x-on:change="updateTypeChapter()" id="chapter_type" class="form-control">
                <option value="regular">Regular</option>
                <option value="special">Special</option>
                <option value="premium">Premium</option>
                <option value="premium_with">Premium w/ Free Artscene</option>
            </select>
       </x-form.group>

    <template x-if="mode == 'chapter' && (typeChapter == 'premium' || typeChapter =='premium_with')">
        <div>
            <div class="form-group">
               <label for=""> Chapter Description </label>
               <div class="alert alert-warning">
                This description will appear with the prompt, confirming whether reader wishes to proceed to the Premium Chapter for a fee. Make it as enticing as possible to lure them in. 
               </div>
               <textarea name="desc" id="" cols="30" rows="10" class="form-control"></textarea>
            </div>
            
            <div class="form-group">
                <label for="">Set Age Restriction</label>
                <select name="age_restriction" id="age_level" class="form-control">
                    <option value="0">
                        None
                    </option>
                    <option value="15">
                        15 and up
                    </option>
                    <option value="18" id="_18">
                        18 and up
                    </option>
                </select>
            </div>
        </div>
    </template>
    <div class="form-group">
        <label for="">Author's Notes </label>
        <textarea name="foot_note" id="" cols="30" rows="10" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for=""> Cost</label>
        <input type="number" name="cost" value="{{ old('cost') ?? 0 }}" class="form-control">
    </div>
    <div class="form-group" id="freeart">

        <div id="freeart-child">
            
            <x-copyright-disclaimer/>

            <x-form.group>
                <x-form.label>Upload Art Scene</x-form.label>
                <x-form.file name="art_photo" label="" accept="image/*"/>
            </x-form.group>

            <div class="form-group">
                <label for="">Art Scene Cost</label>
                <input type="number" name="art_cost" value="{{ old('cost') ?? 0 }}" class="form-control">
            </div>
        </div>
    </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary">Create</button>
        </div>
    </form>
       
@endsection



@section('bottom')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
    <x-vendor.ckeditor/>
    <script>
        
        $(function(){
            let art = $('#freeart-child').detach();

            $('#chapter_type').change(function(){
                if($(this).val() == 'premium_with'){
                    $('#freeart').append(art);
                }else {
                    $('#freeart-child').detach();
                }
            });

            @if(request()->richtext == true)

            CKEDITOR.replace('foot_note', {height:"50vh", toolbarGroups: [{
                "name": "basicstyles",
                "groups": ["basicstyles"]
                },
                {
                "name": "links",
                "groups": ["links"]
                },
                {
                "name": "paragraph",
                "groups": ["list", "blocks"]
                },
                {
                "name": "document",
                "groups": ["mode"]
                },
                {
                "name": "insert",
                "groups": ["insert"]
                },
                {
                "name": "styles",
                "groups": ["styles"]
                }
            ],})
            CKEDITOR.replace('chapter_content', {height:"50vh", toolbarGroups: [{
          "name": "basicstyles",
          "groups": ["basicstyles"]
        },
        {
          "name": "links",
          "groups": ["links"]
        },
        {
          "name": "paragraph",
          "groups": ["list", "blocks"]
        },
        {
          "name": "document",
          "groups": ["mode"]
        },
        {
          "name": "insert",
          "groups": ["insert"]
        },
        {
          "name": "styles",
          "groups": ["styles"]
        }
      ],})

      @endif
        })
    </script>
@endsection
