import mysql from "mysql2/promise"; // need to import mysql2/promise to use the mysql library
//Connects to the database
const executeQuery = async (query,data)=>{

        try{
            
            const db = await mysql.createPool({
                host:'127.0.0.1',
                //the port where mysql server is 
                port:'3306',
                // database name
                database: 'test',
                user: 'root',
                password:'',
                // can elminate last 3 
                waitForConnections: true,
                connectionLimit: 10,
                queueLimit: 0
            });
            
            //now db is connected so now
           
            try{
            
            const connection = await db.getConnection();
            const [result] = await connection.execute(query,data);
            connection.release();
            //console.log("Connected To Database");
            return result;
            }
            catch(error){
                
                console.log(error);
                return error;

            }
        }catch (error){
           // console.log("There was an error when trying to connect");
            console.log(error);
            return  error;
        }


};
export default executeQuery;