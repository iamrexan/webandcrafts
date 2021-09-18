<x-custom-layout>
    <x-slot name="header">
      {{ __('Create new employee') }}
    </x-slot>
    <div class="form-body">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Add Employees</h3>
                        <form class="requires-validation" method="POST" enctype="multipart/form-data" novalidate>
                          @csrf
                            <div class="col-md-12">
                               <input class="form-control" value="{{ old('name', '') }}" type="text" name="name" placeholder="Full Name" required>
                               @error('name')
                                <div style="color: red;">{{ $message }}</div>
                               @enderror
                            </div>

                            <div class="col-md-12">
                              <input class="form-control" type="email" value="{{ old('email', '') }}" name="email" placeholder="E-mail Address" required>
                               @error('email')
                                <div style="color: red;">{{ $message }}</div>
                               @enderror
                            </div>

                           <div class="col-md-12">
                                <select class="form-select mt-3" name="designation_id" value="{{ old('designation_id', '') }}" required>
                                      <option selected disabled value="">Position</option>
                                      @foreach($designation as $desig)
                                      @if (old('designation') == $desig->id)
                                          <option value="{{ $desig->id }}" selected>{{ $desig->name }}</option>
                                      @else
                                          <option value="{{ $desig->id }}">{{ $desig->name }}</option>
                                      @endif
                                      @endforeach
                               </select>
                               @error('designation_id')
                                <div style="color: red;">{{ $message }}</div>
                               @enderror
                           </div>

                            <div class="col-md-12 mt-4">
                              <input type="file" class="form-control custom-file-input" id="customImage" name="photo">
                              <label class="custom-file-label" for="customImage">Choose file</label>
                               @error('photo')
                                <div style="color: red;">{{ $message }}</div>
                               @enderror
                            </div>
                  
                            <div class="form-button mt-3">
                                <button id="submit" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('custom-script')
    <script>
      $('#customImage').on('change',function(){
        var fileName = $(this).val();
        $(this).next('.custom-file-label').html(fileName);
      })
    </script>
    @endpush
</x-custom-layout>