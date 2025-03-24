@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Comments Moderation</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Comments</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-comments me-1"></i>
                Comments List
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Comment</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                            <tr>
                                <td>{{ $comment->rating->customer->name }}</td>
                                <td>
                                    <a href="{{ route('products.show', ['product' => $comment->rating->product]) }}">
                                        {{ Str::limit($comment->rating->product->name, 50, ' ...') }}
                                    </a>
                                </td>
                                <td>{{ $comment->comment }}</td>
                                <td>
                                    {{ $comment->rating->rating }}
                                    <i class="fa fa-star text-info"></i>
                                </td>
                                <td>
                                    <span
                                        class="status-badge badge {{ $comment->status === 'published' ? 'bg-success' : ($comment->status === 'deleted' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ ucfirst($comment->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($comment->status === 'published')
                                        <button type="button" class="btn btn-warning btn-sm pending-btn"
                                            data-id="{{ $comment->id }}">
                                            Set to Pending
                                        </button>
                                    @endif
                                    @if ($comment->status === 'pending')
                                        <button type="button" class="btn btn-success btn-sm publish-btn"
                                            data-id="{{ $comment->id }}">
                                            Publish
                                        </button>
                                    @endif

                                    @if ($comment->status !== 'deleted')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                            data-id="{{ $comment->id }}">
                                            Delete
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-warning btn-sm restore-btn"
                                            data-id="{{ $comment->id }}">
                                            Restore
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {

                function updateStatus(button, newStatus, statusClass) {
                    let row = $(button).closest("tr");
                    let statusBadge = row.find(".status-badge");
                    let actionCell = row.find("td:last-child");

                    statusBadge.fadeOut(200, function() {
                        $(this).removeClass("bg-warning text-dark bg-success bg-danger")
                            .addClass(statusClass)
                            .text(newStatus)
                            .fadeIn(200);
                    });

                    actionCell.children().fadeOut(200, function() {
                        $(this).remove();
                    });

                    setTimeout(() => {
                        if (newStatus === "Deleted") {
                            actionCell.append(createButton("Restore", "restore-btn btn btn-warning btn-sm", $(
                                button).data("id"))).hide().slideDown(200);
                        } else if (newStatus === "Pending") {
                            actionCell.append(createButton("Publish", "publish-btn btn btn-success btn-sm", $(
                                button).data("id"))).hide().slideDown(200);
                            actionCell.append(createButton("Delete", "delete-btn btn btn-danger btn-sm", $(
                                button).data("id"))).hide().slideDown(200);
                        } else if (newStatus === "Published") {
                            actionCell.append(createButton("Set to Pending",
                                    "btn btn-warning btn-sm pending-btn", $(button).data("id"))).hide()
                                .slideDown(200);
                            actionCell.append(createButton("Delete", "delete-btn btn btn-danger btn-sm", $(
                                button).data("id"))).hide().slideDown(200);
                        }
                    }, 250);
                }

                // Fonction pour créer un bouton dynamiquement
                function createButton(text, classes, id) {
                    return `<button class="btn-action ${classes}" data-id="${id}">${text}</button>`;
                }

                // Gestion du bouton "Set to Pending"
                $(document).on("click", ".pending-btn", function() {
                    let button = this;
                    let commentId = $(this).data("id");

                    $.ajax({
                        url: `/dashboard/comment/${commentId}/pending`,
                        type: "PATCH",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        success: function(response) {
                            if (response.success) {
                                updateStatus(button, "Pending", "bg-warning text-dark");
                                alertToastr(response.message, 'success');
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr
                                .responseJSON.message : 'Unknown error';
                            alertToastr(errorMessage, 'error');
                        }
                    });
                });


                // Gestion du bouton "Publish"
                $(document).on("click", ".publish-btn", function() {
                    let button = this;
                    let commentId = $(this).data("id");

                    $.ajax({
                        url: `/dashboard/comment/${commentId}/publish`,
                        type: "PATCH",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        success: function(response) {
                            if (response.success) {
                                updateStatus(button, "Published", "bg-success");
                                alertToastr(response.message, 'success');
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr
                                .responseJSON.message : 'Unknown error';
                            alertToastr(errorMessage, 'error');
                        }
                    });
                });

                // Gestion du bouton "Delete"
                $(document).on("click", ".delete-btn", function() {
                    let button = this;
                    let commentId = $(this).data("id");

                    if (!confirm("Are you sure?")) return;

                    $.ajax({
                        url: `/dashboard/comment/${commentId}`,
                        type: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        success: function(response) {
                            if (response.success) {
                                updateStatus(button, "Deleted", "bg-danger");
                                alertToastr(response.message, 'success');
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr
                                .responseJSON.message : 'Unknown error';
                            alertToastr(errorMessage, 'error');
                        }
                    });
                });

                // Gestion du bouton "Restore"
                $(document).on("click", ".restore-btn", function() {
                    let button = this;
                    let commentId = $(this).data("id");

                    $.ajax({
                        url: `/dashboard/comment/${commentId}/restore`,
                        type: "PATCH",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        success: function(response) {
                            if (response.success) {
                                updateStatus(button, "Pending", "bg-warning text-dark");
                                alertToastr(response.message, 'success');
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr
                                .responseJSON.message : 'Unknown error';
                            alertToastr(errorMessage, 'error');
                        }
                    });
                });

                $('#datatablesSimple').DataTable();
            });
        </script>
    @endpush
@endsection
