package org.screamingsandals.simpleinventories.ide;

import groovy.lang.Binding;
import groovy.util.GroovyScriptEngine;
import groovy.util.ResourceException;
import groovy.util.ScriptException;
import org.screamingsandals.simpleinventories.ide.builder.MainGroovyBuilder;

import java.io.File;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;
import com.fasterxml.jackson.databind.ObjectMapper;

public class Main {
    public static void main(String[] args) throws Exception {
        var tempFile = args[0];
        var resultTempFile = args[1];

        var binding = new Binding();
        MainGroovyBuilder builder = new MainGroovyBuilder();

        binding.setVariable("inventory", builder);
        binding.setVariable("section", "data");
        var engine = new GroovyScriptEngine(new URL[]{new File(tempFile).getParentFile().toURI().toURL()});

        engine.run(tempFile, binding);

        Map<String, Object> ultimateMap = new HashMap<>();
        ultimateMap.put("options", builder.getLocalOptions());
        ultimateMap.put("content", builder.getList());

        ObjectMapper mapper = new ObjectMapper();
        mapper.writeValue(new File(resultTempFile), ultimateMap);
    }
}
