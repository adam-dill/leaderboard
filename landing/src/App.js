import React from 'react';
import './App.css';
import { BrowserRouter as Router, Switch, Route, Link } from 'react-router-dom';
import HomeScreen from './screens/home';
import ApiScreen from './screens/api';

function App() {
  return (
    <Router>
      <div className="App">
        <header className="App-header">
          <h1><Link to="/">LeaderBoards</Link></h1>
          <nav>
            <ul>
              <li><Link to="/">Scores</Link></li>
              <li><Link to="/api">API</Link></li>
            </ul>
          </nav>
        </header>
        <Switch>
          <Route path="/api">
            <ApiScreen />
          </Route>
          <Route path="/">
            <HomeScreen />
          </Route>
        </Switch>
      </div>
    </Router>
  );
}

export default App;
