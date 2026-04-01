<?php
// Test database connection
try {
    $pdo = new PDO('sqlite:../database/database.sqlite');
    echo "✅ SQLite connection successful!<br>";
    
    // Test if we can create a table
    $pdo->exec("CREATE TABLE IF NOT EXISTS test_table (id INTEGER PRIMARY KEY, name TEXT)");
    echo "✅ Table creation successful!<br>";
    
    // Test insert
    $stmt = $pdo->prepare("INSERT INTO test_table (name) VALUES (?)");
    $stmt->execute(['Test Data']);
    echo "✅ Data insertion successful!<br>";
    
    // Test select
    $stmt = $pdo->query("SELECT * FROM test_table");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "✅ Data retrieval successful! Found " . count($results) . " records<br>";
    
    echo "<br><strong>🎉 Database is working perfectly!</strong><br>";
    echo "<a href='/'>Go to Homepage</a><br>";
    echo "<a href='/login'>Go to Login</a><br>";
    echo "<a href='/register'>Go to Register</a>";
    
} catch (Exception $e) {
    echo "❌ Database Error: " . $e->getMessage();
}
?>
