<!-- Modal Thêm Danh Mục -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('user.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalLabel">Tạo Tài Khoản</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label for="name" class="form-label">Tài khoản</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone">
          </div>
          <div class="mb-3">
            <label for="gender" class="form-label">Giới tính</label>
            <select class="form-select" id="gender" name="gender">
              <option value="male">Nam</option>
              <option value="female">Nữ</option>
              <option value="other">Khác</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="birth_date" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date">
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address">
          </div>
          <div class="mb-3">
            <label for="points" class="form-label">Điểm thưởng</label>
            <input type="number" class="form-control" id="points" name="points" value="0">
          </div>
          <div class="mb-3">
            <label for="tier" class="form-label">Cấp độ thành viên</label>
            <select class="form-select" id="tier" name="tier">
              <option value="basic">Basic</option>
              <option value="premium">Premium</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="role_id" class="form-label">Vai trò</label>
            <input type="number" class="form-control" id="role_id" name="role_id">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
      </div>
    </form>
  </div>
</div>

    <!-- Kết thúc Modal -->
