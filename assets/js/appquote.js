$(document).ready(function() {
    var options = {
        target: '#voteoutput',   // target element(s) to be updated with server response
        success: afterSuccess,  // post-submit callback
        resetForm: true        // reset the form after successful submit
    };

    $('#frmVote').submit(function() {
        $(this).ajaxSubmit(options);
        // always return false to prevent standard browser submit and page navigation
        return false;
    });

});

function afterSuccess()
{
    $('#game_vote').hide(); //hide vote dropdown
    $('#submit-btn').hide(); //hide vote submit button
    $('#loading-img').hide(); //hide loading image
}