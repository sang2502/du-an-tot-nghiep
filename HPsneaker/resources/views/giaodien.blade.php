<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Bán Hàng HP Sneaker</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #fbeaea;
            margin: 0;
        }
        .container {
            display: grid;
            grid-template-columns: 220px 1fr 350px;
            grid-template-rows: 60px 1fr;
            gap: 12px;
            height: 100vh;
        }
        .sidebar {
            grid-row: 1 / span 2;
            background: #fff0f0;
            color: #a94442;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-right: 2px solid #a94442;
        }
        .sidebar h2 {
            margin: 18px 0 24px 0;
            font-size: 28px;
            color: #a94442;
            font-weight: bold;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            width: 100%;
        }
        .sidebar ul li {
            padding: 14px 0 14px 32px;
            font-size: 18px;
            cursor: pointer;
            border-bottom: 1px solid #f3c6c6;
            transition: background 0.2s;
        }
        .sidebar ul li:hover {
            background: #f3c6c6;
        }
        .main {
            grid-column: 2;
            grid-row: 1 / span 2;
            padding: 18px 12px 12px 12px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(169,68,66,0.08);
            overflow-y: auto;
        }
        .panel {
            background: #fff7f7;
            border: 1.5px solid #a94442;
            border-radius: 8px;
            margin-bottom: 14px;
            padding: 12px;
        }
        .panel h3 {
            color: #a94442;
            margin-top: 0;
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            border: 1px solid #e7bcbc;
            padding: 7px 10px;
            text-align: left;
            font-size: 15px;
        }
        th {
            background: #f3c6c6;
            color: #a94442;
        }
        .rightbar {
            grid-column: 3;
            grid-row: 1 / span 2;
            background: #fff7f7;
            border-left: 2px solid #a94442;
            padding: 18px 16px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .form-group {
            margin-bottom: 10px;
        }
        label {
            color: #a94442;
            font-weight: 500;
        }
        input, select {
            width: 100%;
            padding: 6px;
            border-radius: 5px;
            border: 1px solid #e7bcbc;
            margin-top: 3px;
        }
        .btn {
            background: #a94442;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 18px;
            font-size: 17px;
            cursor: pointer;
            margin-top: 8px;
            margin-right: 8px;
            transition: background 0.2s;
        }
        .btn:hover {
            background: #d9534f;
        }
        .btn-danger {
            background: #d9534f;
        }
        .btn-success {
            background: #5cb85c;
        }
        .btn-create {
            background: #2563eb !important;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 0;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(37,99,235,0.12);
            transition: background 0.2s;
        }
        .btn-create:hover {
            background: #1d4ed8 !important;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <h2>HP Sneaker</h2>
        <ul>
            <li>🛒 Bán Hàng</li>
            <li>🧾 Hoá Đơn</li>
            <li>📂 Danh Mục</li>
            <li>👕 Sản Phẩm</li>
            <li>🏷️ Khuyến Mại</li>
            <li>📊 Thống Kê</li>
            <li>👤 Nhân Viên</li>
            <li>🔒 Đổi Mật Khẩu</li>
            <li>🚪 Đăng Xuất</li>
        </ul>
        <button class="btn btn-create" style="width:90%;margin:18px 0 0 0;font-size:18px;background:#2563eb;">
            <span style="font-size:22px;">&#43;</span> Tạo Hoá Đơn
        </button>
    </div>
    <div class="main">
        <div class="panel">
            <h3>Hoá Đơn Chờ</h3>
            <table>
                <thead>
                    <tr>
                        <th>Mã Hoá Đơn</th>
                        <th>Ngày Lập</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>2025-06-05</td><td>2025-06-05</td><td>Huỷ</td></tr>
                    <tr><td>2025-11-26</td><td>2025-11-26</td><td>Hoàn thành</td></tr>
                    <!-- ...Thêm dữ liệu mẫu hoặc dùng vòng lặp Blade... -->
                </tbody>
            </table>
        </div>
        <div class="panel">
            <h3>Danh Sách Khách Hàng</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tên Khách Hàng</th>
                        <th>Số Điện Thoại</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Phạm Văn An</td><td>0915211232</td></tr>
                    <tr><td>Lê Thị Bích</td><td>0915211230</td></tr>
                    <!-- ... -->
                </tbody>
            </table>
        </div>
        <div class="panel">
            <h3>Danh Sách Sản Phẩm</h3>
            <table>
                <thead>
                    <tr>
                        <th>Mã Sản Phẩm</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Danh Mục</th>
                        <th>Màu Sắc</th>
                        <th>Kích Thước</th>
                        <th>Số Lượng</th>
                        <th>Đơn Giá</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>Áo thun</td><td>Áo</td><td>Đỏ</td><td>L</td><td>100</td><td>150000</td></tr>
                    <!-- ... -->
                </tbody>
            </table>
        </div>
        <div class="panel">
            <h3>Chi Tiết Hoá Đơn</h3>
            <table>
                <thead>
                    <tr>
                        <th>Mã Sản Phẩm</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Danh Mục</th>
                        <th>Màu Sắc</th>
                        <th>Kích Thước</th>
                        <th>Số Lượng Bán</th>
                        <th>Thành Tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>Áo thun</td><td>Áo</td><td>Đỏ</td><td>L</td><td>2</td><td>300000</td></tr>
                    <!-- ... -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="rightbar">
        <div class="panel">
            <h3>Hoá Đơn</h3>
            <div class="form-group">
                <label>Thông Tin Khách Hàng:</label>
                <input type="text" placeholder="Tên khách hàng">
            </div>
            <div class="form-group">
                <label>Số Điện Thoại:</label>
                <input type="text" placeholder="Số điện thoại">
            </div>
            <button class="btn btn-success">Thêm</button>
        </div>
        <div class="panel">
            <h3>Thông Tin Hoá Đơn</h3>
            <div class="form-group">
                <label>Ngày Thành Lập:</label>
                <input type="date">
            </div>
            <div class="form-group">
                <label>Số Lượng SP:</label>
                <input type="number">
            </div>
            <div class="form-group">
                <label>Tổng Tiền SP:</label>
                <input type="number">
            </div>
            <div class="form-group">
                <label>Code Khuyến Mại:</label>
                <input type="text">
            </div>
            <div class="form-group">
                <label>Tổng Tiền Khuyến Mại:</label>
                <input type="number">
            </div>
            <div class="form-group">
                <label>Tổng Thanh Toán:</label>
                <input type="number">
            </div>
            <div class="form-group">
                <label>Phương Thức TT:</label>
                <select>
                    <option>Tiền Mặt</option>
                    <option>Chuyển Khoản</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tiền Khách Đưa:</label>
                <input type="number">
            </div>
            <div class="form-group">
                <label>Tiền Hoàn Lại:</label>
                <input type="number">
            </div>
            <div class="actions">
                <button class="btn btn-danger">🗑️ Xoá Hoá Đơn</button>
                <button class="btn btn-success">💰 Thanh Toán</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>