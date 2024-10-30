(function ($) {
  "use strict";

  var ajax = mimiAdminLocalizer;

  var searchFormMain = $("#mimi-search-form-main");
  var searchFormsList = $("#mimi-search-forms-list");

  var posts = [];

  var formNameInput = $("#mimi-form-name-input");
  var shortcodeInput = $("#mimi-shortcode-input");
  var pagesSearchScopeCheckbox = $("#mimi-pages-search-scope-checkbox");
  var postsSearchScopeCheckbox = $("#mimi-posts-search-scope-checkbox");
  var productsSearchScopeChechbox = $("#mimi-products-search-scope-checkbox");

  var copySearchFormBtn = $("#mimi-copy-search-form-btn");
  var deleteSearchFormBtn = $("#mimi-delete-search-form-btn");

  function saveSearchFormAjax() {
    var formNameInputValue = formNameInput.val();

    var pagesSearchScopeCheckboxValue =
      pagesSearchScopeCheckbox.is(":checked") == true ? 1 : 0;
    var postsSearchScopeCheckboxValue =
      postsSearchScopeCheckbox.is(":checked") == true ? 1 : 0;
    var productsSearchScopeCheckboxValue =
      productsSearchScopeChechbox.is(":checked") == true ? 1 : 0;

    var searchFormID = searchFormMain.data("value");

    if (searchFormID == "") {
      $.ajax({
        type: "POST",
        url: ajax.ajaxUrl,
        data: {
          action: "mimi_save_search_form_ajax_action",
          nonce: ajax.nonce,
          formName: formNameInputValue,
          pagesSearchScope: pagesSearchScopeCheckboxValue,
          postsSearchScope: postsSearchScopeCheckboxValue,
          productsSearchScope: productsSearchScopeCheckboxValue,
        },
        success: function (response) {
          getSearchFormsAjax();
          resetForm();

          showToastMessage();
        },
      });
    } else {
      $.ajax({
        type: "POST",
        url: ajax.ajaxUrl,
        data: {
          action: "mimi_save_search_form_ajax_action",
          nonce: ajax.nonce,
          id: searchFormID,
          formName: formNameInputValue,
          pagesSearchScope: pagesSearchScopeCheckboxValue,
          postsSearchScope: postsSearchScopeCheckboxValue,
          productsSearchScope: productsSearchScopeCheckboxValue,
        },
        success: function (response) {
          getSearchFormsAjax();
          // resetForm();
          showToastMessage();
        },
      });
    }
  }

  function getSearchFormsAjax() {
    $.ajax({
      type: "GET",
      url: ajax.ajaxUrl,
      data: {
        action: "mimi_get_search_form_posts_ajax_action",
        nonce: ajax.nonce,
      },
      success: function (response) {
        const responseData = JSON.parse(response);
        if (responseData.isSuccess == true) {
          posts = responseData.data;

          searchFormsList.empty();

          posts.forEach((post) => {
            var html = generateSearchFormItems(
              post.id,
              post.title,
              post.shortcode
            );
            searchFormsList.append(html);
          });

          searchFormMain.show();
        }
      },
    });
  }

  function getSearchFormByID(id) {
    // Sử dụng phương thức find() để tìm bài viết có ID là id
    var foundPost = posts.find(function (post) {
      return post.id === id;
    });

    if (foundPost) {
      var title = foundPost.title;
      var shortcode = foundPost.shortcode;
      var searchScope = foundPost.searchScope;

      copySearchFormBtn.show();
      deleteSearchFormBtn.show();

      setForm(
        title,
        shortcode,
        searchScope.mimi_pages,
        searchScope.mimi_posts,
        searchScope.mimi_products
      );
    }
  }

  function setForm(
    title,
    shortcode,
    pagesSearchScope,
    postsSearchScope,
    productsSearchScope
  ) {
    formNameInput.val(title);
    shortcodeInput.val(shortcode);
    pagesSearchScopeCheckbox.prop(
      "checked",
      pagesSearchScope == 1 ? true : false
    );
    postsSearchScopeCheckbox.prop(
      "checked",
      postsSearchScope == 1 ? true : false
    );
    productsSearchScopeChechbox.prop(
      "checked",
      productsSearchScope == 1 ? true : false
    );
  }

  function resetForm() {
    searchFormMain.data("value", "");
    formNameInput.val("");
    shortcodeInput.val("");
    pagesSearchScopeCheckbox.prop("checked", false);
    postsSearchScopeCheckbox.prop("checked", false);
    productsSearchScopeChechbox.prop("checked", false);
  }

  function showToastMessage() {
    $(".mimi-success-message").css("transform", "translateX(-160%)");

    setTimeout(function () {
      $(".mimi-success-message").css("transform", "");
    }, 3000);
  }

  function generateSearchFormItems(id, title, shortcode) {
    var htmlContent = `
        <li id="mimi-search-form-item" data-value="${id}" class="mimi-search-form-item mimi-border-0 mimi-border-solid mimi-border-l-[3px] mimi-border-[#D9D9D9] mimi-border-l-transparent mimi-flex mimi-cursor-pointer mimi-justify-between mimi-items-center mimi-px-[7px] mimi-pr-0 mimi-border-b-2 mimi-mb-0 mimi-h-[58px]">
            <div>
                <div class="mimi-text-[15px] mimi-font-semibold">
                    ${title}
                </div>
                <div class="mimi-text-[11px] mimi-font-normal mimi-text-[#9D9DA0]">
                    ${shortcode}
                </div>
            </div>
        </li>`;
    return htmlContent;
  }

  function copyToClipboard(text) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(text).select();
    document.execCommand("copy");
    $temp.remove();
    alert("Copied to clipboard!");
  }

  $(document).ready(function () {
    getSearchFormsAjax();

    searchFormsList.on("click", "#mimi-search-form-item", function () {
      $(".mimi-search-form-item").removeClass("mimi-search-form-active");
      $(this).addClass("mimi-search-form-active");
      resetForm();
      var id = $(this).data("value");
      searchFormMain.data("value", id);
      getSearchFormByID(id);
    });

    $("#mimi-shortcode-create-new").on("click", function () {
      copySearchFormBtn.hide();
      deleteSearchFormBtn.hide();
      resetForm();
    });

    $("#mimi-save-search-form-btn").on("click", function () {
      saveSearchFormAjax();
    });

    deleteSearchFormBtn.on("click", function () {
      var id = searchFormMain.data("value");

      $.ajax({
        type: "POST",
        url: ajax.ajaxUrl,
        data: {
          action: "mimi_delete_search_form_ajax_action",
          id: id,
          nonce: ajax.nonce,
        },
        success: function (response) {
          copySearchFormBtn.hide();
          deleteSearchFormBtn.hide();
          getSearchFormsAjax();
          resetForm();
        },
      });
    });

    $("#mimi-copy-search-form-btn").on("click", function () {
      var shortcodeInputVal = shortcodeInput.val();
      copyToClipboard(shortcodeInputVal);
    });
  });
})(jQuery);
