from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from fastapi.staticfiles import StaticFiles 
from index_router import index

import uvicorn


app = FastAPI()
app.mount("/static", StaticFiles(directory="static"), name="static")

app.include_router(index, prefix="/api",tags=["登录接口"])

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"], # 开发环境允许所有前端域名，生产环境改具体域名
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

if __name__ == '__main__':
    uvicorn.run("main:app",host="127.0.0.1",port=8080)