# index_router.py
from fastapi import APIRouter, HTTPException
from pydantic import BaseModel

# 初始化路由对象，和你原有代码一致
index = APIRouter()

# 定义登录请求的参数模型（Pydantic）
# 前端必须传 username(str) 和 password(str)，自动做类型校验
class LoginRequest(BaseModel):
    username: str
    password: str

# 模拟数据库中的合法账号密码（实际项目替换为MySQL/Redis/MongoDB查询）
VALID_USER = {
    "admin": "123456",  # 测试账号1
    "user1": "123456"   # 测试账号2
}

# 登录接口：POST请求，路径/api/login（因为main.py中挂载了/api前缀）
@index.post("/login", summary="用户登录")
def user_login(login_info: LoginRequest):
    # 从请求体中获取前端传的用户名和密码
    username = login_info.username
    password = login_info.password
    
    # 1. 校验用户名是否存在
    if username not in VALID_USER:
        # 抛出400错误，返回自定义提示
        raise HTTPException(status_code=400, detail="用户名不存在")
    
    # 2. 校验密码是否正确
    if VALID_USER[username] != password:
        raise HTTPException(status_code=400, detail="密码错误")
    
    # 登录成功，返回统一格式的响应（可扩展返回token、用户信息等）
    return {
        "code": 200,        # 自定义状态码（成功200，失败400/500）
        "msg": "登录成功",  # 提示信息
        "data": {           # 自定义返回数据，按需扩展
            "username": username,
            "token": f"fake_token_{username}_123"  # 模拟token，实际项目用JWT生成
        }
    }