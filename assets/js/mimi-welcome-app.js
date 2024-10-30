(function ($) {
  "use strict";

  var ajax = mimiAdminLocalizer;

  const totalProcess = 6;
  var currentProcess = 0;
  var currentPercent = 0;

  var url = "";
  var textWhenDone = "";

  var hasWoocommerce = 0;
  var apiKey = "";
  var urlImportAllDatasFromSite = "";
  var allDatasFromSite = [];
  var urlImportRelatedProducts = "";
  var relatedProducts = [];
  var urlImportBoughtTogether = "";
  var boughtTogether = [];

  function initSiteActionAjax() {
    $.ajax({
      type: "POST",
      url: ajax.ajaxUrl,
      data: {
        action: "mimi_init_site_ajax_action",
        nonce: ajax.nonce,
      },
      success: function (response) {
        const responseData = JSON.parse(response);
        if (responseData.isSuccess == true) {
          url = responseData.url;
          textWhenDone = responseData.textWhenDone;
          currentProcess++;
          updateProgressPercent(currentProcess);
          getDataFromSiteAjax();
        }
      },
    });
  }

  function getDataFromSiteAjax() {
    $.ajax({
      type: "GET",
      url: ajax.ajaxUrl,
      data: {
        action: "mimi_get_data_from_site_ajax_action",
        nonce: ajax.nonce,
      },
      success: function (response) {
        const responseData = JSON.parse(response);
        if (responseData.isSuccess == true) {
          hasWoocommerce = responseData.hasWoocomerce;
          apiKey = responseData.apiKey;
          urlImportAllDatasFromSite = responseData.urlImportAllDatasFromSite;
          allDatasFromSite = responseData.allDatasFromSite;
          urlImportRelatedProducts = responseData.urlImportRelatedProducts;
          relatedProducts = responseData.relatedProducts;
          urlImportBoughtTogether = responseData.urlImportBoughtTogether;
          boughtTogether = responseData.boughtTogether;

          currentProcess++;
          updateProgressPercent(currentProcess);
          importSiteData();
        }
      },
    });
  }

  function importSiteData() {
    fetch(urlImportAllDatasFromSite, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "x-api-key": apiKey,
      },
      body: JSON.stringify(allDatasFromSite),
    }).then((response) => {
      if (hasWoocommerce == 1) {
        currentProcess++;
        updateProgressPercent(currentProcess);
        importRelatedProduct();
      } else {
        currentProcess = 5;
        updateProgressPercent(currentProcess);
        updateStatusImportedDataAjax();
      }
    });
  }

  function importRelatedProduct() {
    fetch(urlImportRelatedProducts, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "x-api-key": apiKey,
      },
      body: JSON.stringify(relatedProducts),
    }).then((response) => {
      currentProcess++;
      updateProgressPercent(currentProcess);
      importBoughtTogether();
    });
  }

  function importBoughtTogether() {
    fetch(urlImportBoughtTogether, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "x-api-key": apiKey,
      },
      body: JSON.stringify(boughtTogether),
    }).then((response) => {
      currentProcess++;
      updateProgressPercent(currentProcess);
      updateStatusImportedDataAjax();
    });
  }

  function updateStatusImportedDataAjax() {
    $.ajax({
      type: "POST",
      url: ajax.ajaxUrl,
      data: {
        action: "mimi_update_status_imported_data_ajax_action",
        nonce: ajax.nonce,
      },
      success: function (response) {
        const responseData = JSON.parse(response);
        if (responseData.isSuccess == true) {
          currentProcess++;
          updateProgressPercent(currentProcess);
        }
      },
    });
  }

  function updateProgressPercent(currentProcess) {
    var percentComplete = (currentProcess / totalProcess) * 100;
    percentComplete = Math.min(Math.max(percentComplete, 0), 100);

    var interval = setInterval(function () {
      if (currentPercent >= percentComplete) {
        clearInterval(interval);
        return;
      }
      currentPercent++;
      $("#mimi-progress-bar").css("width", currentPercent + "%");
      $("#mimi-percent-progress-bar").css("left", currentPercent - 2 + "%");
      $("#mimi-percent-progress-bar-content").html(
        Math.round(currentPercent) + "%"
      );

      if (currentPercent < 100) {
        $("#mimi-progress-bar").css("width", currentPercent + "%");
        $("#mimi-percent-progress-bar").css("left", currentPercent - 1 + "%");
        $("#mimi-percent-progress-bar-content").html(
          Math.round(currentPercent) + "%"
        );
      } else {
        $("#mimi-start-using-btn").prop("disabled", false);
        $("#mimi-start-using-btn").css("background-color", "rgb(254,147,0)");

        $("#mimi-text-notification").html(textWhenDone);
      }
    }, 50); // Thay đổi số 50 thành số milliseconds để cập nhật tốc độ
  }

  $(document).ready(function () {
    $("#mimi-start-using-btn").prop("disabled", true);

    initSiteActionAjax();

    $("#mimi-start-using-btn").click(function () {
      if (url != "" && url != undefined) {
        window.location.href = url;
      }
    });
  });
})(jQuery);
