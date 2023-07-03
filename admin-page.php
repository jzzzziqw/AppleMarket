<?php
    include('./top.php');
    ?>
     <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="input-form">
              <h4 class="mb-3"><br><br>관리자 로그인</h4>
              <form class="validation-form" action="admin.php" method="post">
                <div class="form-group">
                  <label for="username">관리자 아이디</label>
                  <input type="text" class="form-control" id="id" placeholder="아이디를 입력하세요" name='id' required>
                  <div class="invalid-feedback">
                    아이디를 입력해주세요.
                  </div>
                </div>
    
                <div class="form-group">
                  <label for="password">비밀번호</label>
                  <input type="password" class="form-control" id="password" name='password' placeholder="비밀번호를 입력하세요" required>
                  <div class="invalid-feedback">
                    비밀번호를 입력해주세요.
                  </div>
                </div>
    
                <br>
                <button class="btn btn-primary btn-block" type="submit">로그인</button>&nbsp;&nbsp;

              </form>
              <br><br>
            </div>
          </div>
        </div>
      </div>
      <br>
<?php 
     include('./btm.php');
    ?>
</body>

</html>