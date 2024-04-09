import React from "react";
import Link from "next/link";

export default function NavBar(){
    return (
        <div>
            <Link  href={"/login/loginPage"}><h1>Login</h1></Link>
            <Link href={"/login/createNewUser"}> <h1>Register</h1></Link>
            <Link href ={"/api/conectApi"}></Link>
            
            <Link href ={"/login/forgotPassword"}><h1>Forgot Password</h1></Link>
        </div>
    )

}