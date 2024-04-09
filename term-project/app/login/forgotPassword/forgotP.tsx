
'use client';
import React from "react";
import { useState } from "react";
import NavBar from "@/app/components/navBar";


export default function ForgotPassword(){
    // Used to store the usernames and passwords 
   
    const [fgUserName, setfgUserName] = useState('');
    const [fgPassword, setfgPassword] = useState('');


   
    return(
   
  

        <div>
            <div>
                <NavBar></NavBar>
                <br/>
            </div>
                <h1>Login:</h1>
               
                <input type="text" id="userName" placeholder="User Name" value = {fgUserName} onChange= {(e) => setfgUserName(e.target.value)}></input>
                <input type="text" id="pwd" placeholder="Password" value = {fgPassword} onChange= {(e) => setfgPassword(e.target.value)}></input>
                <button type="button" >Submit</button><br/>
                <button type="button">Forgot Password</button><br/>
                <button type="button">Create Account</button><br/>
           
            </div>


    )
    
    
}
