(function ($) {
  $(document).ready(function ($) {
    var filter = $("#form");
    var form = $("[data-js-form=filter]");

    $("select#solution").on("change", function () {
      var choosen = $(this).find(":selected").text()
      var data = {
        action: "termsss",
        bysolution: choosen,
      };

      $.ajax({
        url: "/wp-admin/admin-ajax.php",
        data: data,
        success: function (response) {
          if (choosen === "All") {
            $("select#industry option").remove();
            $("select#industry").append($("<option></option>").attr("value", "").attr('selected', 'selected').text("All"));
            $.each(JSON.parse(response), function (index, value) {
              $("select#industry").append($("<option></option>").attr("value", value.slug).text(value.name));
            });
            form.submit();
          } else if ($.trim(response[0]) !== '') {
            $("select#industry option").remove();
            $.each(response, function (index, value) {
              $("select#industry").append($("<option></option>").attr("value", value.slug).text(value.name));
            });
          }
        }
      });
    })

    form.submit(function (e) {
      e.preventDefault();
      filter.find("#response-content").empty();
      filter.find("#response-content").append('<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
      if (typeof pag !== "undefined" && pag === true) {
        paginate = paginate
      } else {
        paginate = 1
      }
      pag = false;
      $('#paginate').hide();
      var data = {
        action: "filter",
        search: $("#search").val(),
        industry: $("#industry").val(),
        solution: $("#solution").val(),
        paginate: paginate
      };

      $.ajax({
        url: "/wp-admin/admin-ajax.php",
        data: data,
        success: function (response) {
          filter.find("#response-content").empty();

          if ($.trim(response[0]) === '') {
            $("#response-content").html('<h4>No search results for your search criteria</h4>');
          }
          if (response[0]) {
            maximum = response[0].max;
          } else {
            maximum = 1;
          }
          for (var i = 0; i < response.length; i++) {
            var html = `
            <div class="mosaic-resource-bucket">
              <div class="post">
                <div>
                  <div class="featured-image">
                  <a href="${response[i].permalink}"><img src="${response[i].image}" alt="${response[i].title}"></a>
                  </div>
                  <div class="content">
                    <h3 class="h5"><a href="${response[i].permalink}">${response[i].title}</a></h3>

                    <div class="button-wrapper">
                      <a class="button white-button small-button read-more" href="${response[i].permalink}">
                        <span>Read More</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          `;
            filter.find("#response-content").append(html);
            $('#paginate').show();
          }

          $("#paginate").empty();
          for (let i = 1; i < maximum + 1; i++) {
            if (maximum > 1) {
              $("#paginate").append('<a class="btn-number page-numbers" data-paginate="' + i + '">' + i + '</a>')
            }
          }

          $(".btn-number[data-paginate='" + paginate + "']").addClass('current');
          $(".btn-number").click(function (e) {
            e.preventDefault();
            pag = true;
            paginate = $(this).data("paginate");
            form.submit();
          });
        }
      });
      // Initial triger for ajax pagination
      $(".btn-number").click(function (e) {
        e.preventDefault();
        pag = true;
        paginate = $(this).data("paginate");
        form.submit();
      });
    });
    //Initial display

    //Display on search
    $("form").on("keyup", "#search", function () {
      if ($("#search").val().length > 3) {
        $(this)
          .closest("form")
          .submit();
      } else {
        form.find("#response-content").empty();
      }
    });

    // Display on select
    $("form select").on("change", function () {
      $(this)
        .closest("form")
        .submit();
    });

    form.submit();

  });

})(jQuery)