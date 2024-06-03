@extends('layouts.main')

@section('container')
    <!-- Service Section -->
    <div class="container" style="margin-top:8rem">
        <div class="row justify-content-center mb-5">
            <div class="col-md-12">

            <h1 class="mb-5">Panduan Penangan Insiden Siber</h1>

                <article class="my-4 fs-6">
                    <div class="table-responsive col-auto">
                          <table class="table table-striped table-sm">
                            <thead class="table-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Size</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach ($guidances as $key => $guidance)
                                <tr>
                                  <td>{{ $guidances->firstItem() + $key }}</td>
                                  <td> <a href="{{ 'storage/' .  $guidance->path }}" target="_blank">{{ $guidance->name }}</a> </td>
                                  <td>{{ number_format(round($guidance->size / 1024, 2),2,",",".") }} Kb</td>
                                </tr>    
                                @endforeach
                            </tbody>
                          </table>
                          <div class="d-flex align-items-center justify-content-between">
                              <div class="mb-3">
                                  Showing 
                                  {{ $guidances->firstItem() }}
                                  to
                                  {{ $guidances->lastItem() }}
                                  of 
                                  {{ $guidances->total() }}
                                  enteries
                              </div>
                              <div class="pagination pagination-sm">
                                  {{ $guidances->links() }}
                              </div>
                          </div>
                    </div>
                </article>
                
            </div>
        </div>
    </div> 
    <!-- End Service Section -->
@endsection