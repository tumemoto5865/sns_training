<?php
require('app/manage_parts/functions.php');
include('app/manage_parts/_header.php');

?>
<main>
  <h1>検索フォーム</h1>
  <div class="main">

    <form action="searchresult.php" method="get">
      <span class="input-form">
        <p>
          <label for="user_id">ID</label>
          <input type="text" name="user_id" id="user_id"><br />
        </p>
        <p>
          <label for="user_name">お名前</label>
          <input type=text name="user_name" id="user_name"><br />
        </p>
        <p>
          <label for="user_sex">性別</label>
          <input type="radio" name="user_sex" value="" id="user_sex3" checked>全て
          <input type="radio" name="user_sex" value="1" id="user_sex1" style="margin-left: 48px;">男性
          <input type="radio" name="user_sex" value="2" id="user_sex2">女性<br />

        </p>
        <p>
          <label for="user_address">住所</label>
          <input type=text name="user_address" id="user_address"><br />
        </p>
        <p>
          <label for="user_tel">電話番号</label>
          <input type=text name="user_tel" id="user_tel"><br />
        </p>
        <p>
          <label for="user_mail_address">メールアドレス</label>
          <input type=text name="user_mail_address" id="user_mail_address" <br />
        </p>
        <p>
          <label for="user_mobile_device">モバイル端末</label>
          <select name="user_mobile_device" id=user_mobile_device>
            <option value="">全て</option>
            <option value="1">iphone</option>
            <option value="2">android</option>
            <option value="3">その他</option>
          </select><br />
        </p>
      </span>
      <p>
        <input type="submit" value="検索" class="submit">
      </div>
    </p>
  </form>
  <button type="button" onclick="location.href='db_manage.php'" class="submit">管理TOPへ戻る</button>
</main>
<?php
include('app/manage_parts/_footer.php');
