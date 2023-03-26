;(function ($) {
  $(document).ready(function () {
    // Complete the task
    $(".complete").on("click", function () {
      let id = $(this).data("taskid")
      $("#complete-task-id").val(id)
      $("#complete-task").submit()
    })

    // In Complete the task
    $(".incomplete").on("click", function () {
      let id = $(this).data("taskid")
      $("#in-complete-task-id").val(id)
      $("#in-complete-task").submit()
    })

    // In Complete the task
    $(".delete").on("click", function () {
      if (confirm("Are you sure to delete the task?")) {
        let id = $(this).data("taskid")
        $("#delete-task-id").val(id)
        $("#delete-task").submit()
      }
    })

    // Bulk Delete Tasks
    $("#bulksubmit").on("click", function () {
      if ($("#action").val() == "bulkdelete") {
        if (!confirm("Are you sure to delete all the task?")) {
          return false
        }
      }
    })
  })
})(jQuery)
