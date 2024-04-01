import mysql from "mysql2/promise";
//Connects to the database
const executeQuery = async (query,data)=>{

        try{
            const db = mysql.createPool({
                host:'127.0.0.1',
                port:'3306',
                database: 'test',
                user: 'root',
                password:'',
                waitForConnections: true,
                connectionLimit: 10,
                queueLimit: 0
            });
            
            const connection = await db.getConnection();
            const [result] = await connection.execute(query,data);
            connection.release();
            console.log("Connected To Database")
            return result;
        }catch (error){
            console.log("There was an error when trying to connect");
            console.log(error);
            return new Error(error);
        }


};
export default executeQuery;