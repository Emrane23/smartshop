<!-- Rating Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalTitle">Rate this product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ratingForm" action="{{ route('send.rating') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" id="modalProductId">
                    <input type="hidden" name="order_id" id="modalOrderId">

                    <div class="mb-3">
                        <label class="form-label">Your rating:</label>
                        <div id="starRating" class="rating-container">
                            <div class="stars">
                                <i class="fa fa-star" data-value="1"></i>
                                <i class="fa fa-star" data-value="2"></i>
                                <i class="fa fa-star" data-value="3"></i>
                                <i class="fa fa-star" data-value="4"></i>
                                <i class="fa fa-star" data-value="5"></i>
                            </div>
                            <span id="ratingValue">0</span>/5
                        </div>
                        <input type="hidden" name="rating" id="ratingInput">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your review:</label>
                        <textarea class="form-control" name="comment" id="commentText" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Send rating</button>
                </form>
            </div>
        </div>
    </div>
</div>