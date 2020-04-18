@extends('layouts.app')

@section('title', 'Templates')

@section('content')

<div class="card my-4">
    <div class="card-header d-flex align-items-center justify-content-between"><h5>{{ __('Templates') }}</h5>
        @if (!$templates->isEmpty())
        <a href="{{ route('selectNewTemplate') }}" class="btn btn-primary">{{ __('Add Template') }}</a>
        @endif
    </div>

    @if ($templates->isEmpty())

    @component('maileclipse::layout.emptydata')

        <span class="mt-4">{{ __("We didn't find anything - just empty space.") }}</span>
        <a class="btn btn-primary mt-3" href="{{ route('selectNewTemplate') }}">{{ __('Add New Template') }}</a>

    @endcomponent

    @endif
    <!---->
</div>

@if (!$templates->isEmpty())
    <!---->

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Templates</h3>
        </div>
        <div class="card-body">
            <table id="templates_list" class="table table-bordered table-hover dataTable dtr-inline">
                <thead>
                <tr>
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Description') }}</th>
                    <th scope="col">{{ __('Template') }}</th>
                    <th scope="col">{{ __('') }}</th>
                    <th scope="col" class="text-center">{{ __('Type') }}</th>
                    <th scope="col" class="text-center">Action</th>

                </tr>
                </thead>
                <tbody>
                @foreach($templates->all() as $template)
                    <tr id="template_item_{{ $template->template_slug }}">
                        <td class="pr-0">{{ ucwords($template->template_name) }}</td>
                        <td class="text-muted" title="/tee">{{ $template->template_description }}</td>

                        <td class="table-fit">{{ ucfirst($template->template_view_name) }}</td>


                        <td class="table-fit text-muted">{{ ucfirst($template->template_skeleton) }}</td>

                        <td class="table-fit text-center">{{ ucfirst($template->template_type) }}</td>

                        <td class="table-fit text-center">
                            <a href="{{ route('viewTemplate', [ 'templatename' => $template->template_slug ]) }}" class="table-action mr-3">
                                <button class="btn btn-primary">Edit</button>
                            </a>
                            <a href="#" class="table-action remove-item" data-template-slug="{{ $template->template_slug }}" data-template-name="{{ $template->template_name }}">
                                <button class="btn btn-danger">Delete</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif


<script type="text/javascript">

    $('.remove-item').click(function(){
        var templateSlug = $(this).data('template-slug');
        var templateName = $(this).data('template-name');

    notie.confirm({

        text: 'Are you sure you want to do that?<br>Delete Template <b>'+ templateName +'</b>',

    submitCallback: function () {

    axios.post('{{ route('deleteTemplate') }}', {
        templateslug: templateSlug,
    })
    .then(function (response) {

        if (response.data.status == 'ok'){
            notie.alert({ type: 1, text: 'Template deleted', time: 2 });

            jQuery('tr#template_item_' + templateSlug).fadeOut('slow');

            var tbody = $("#templates_list tbody");

            console.log(tbody.children().length);

            if (tbody.children().length <= 1) {
                location.reload();
            }

        } else {
            notie.alert({ type: 'error', text: 'Template not deleted', time: 2 })
        }
    })
    .catch(function (error) {
        notie.alert({ type: 'error', text: error, time: 2 })
    });

  }
})

    });



</script>

@endsection
