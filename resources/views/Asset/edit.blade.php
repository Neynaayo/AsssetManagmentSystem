<x-app-web-layout>


    <x-slot name="title">
       Edit Asset
    </x-slot>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                <div class="alert alert-success">{{session('status')}}</div>  
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Add Asset
                            <a href="{{url('Asset')}}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                            <form action="{{url('Asset/'.$assets->id.'/edit')}}" method="POST">
                                @csrf 
                                @method('PUT')

                                <div class="mb-3">
                                    <label>Asset Number</label>
                                    <input type="text" name="asset_no" class="form-control" value="{{$assets->asset_no}}"/>    
                                @error('asset_no') <span class="text-danger">{{$message}}</span>@enderror                   
                                </div>

                                <div class="mb-3">
                                <label>Asset Name</label>
                                <input type="text" name="asset_name" class="form-control" value="{{$assets->asset_name}}"/>    
                                @error('asset_name') <span class="text-danger">{{$message}}</span>@enderror                  
                            </div>

                                <div class="mb-3">
                                <label>Serial Number</label>
                                <input type="text" name="serial_number" class="form-control" value="{{$assets->serial_number}}"/>    
                                @error('serial_number') <span class="text-danger">{{$message}}</span>@enderror                      
                            </div>

                                    <div class="mb-3">
                                        <label>Location</label>
                                        <input type="text" name="location" class="form-control" value="{{$assets->location}}"/>    
                                        @error('location') <span class="text-danger">{{$message}}</span>@enderror                      
                                    </div>

                                    <div class="mb-3">
                                    <label>Brand</label>
                                    <input type="text" name="brand" class="form-control" value="{{$assets->brand}}"/>    
                                    @error('brand') <span class="text-danger">{{$message}}</span>@enderror                      
                                </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>

                            </form>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-web-layout>