package org.screamingsandals.simpleinventories.ide.builder;

import groovy.lang.Closure;
import lombok.Getter;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

@Getter
public class MainGroovyBuilder extends GroovyBuilder {
    private final Map<String, Object> localOptions = new HashMap<>();

    private final List<Object> list = new ArrayList<>();

    public void define(String definition) {
        putItem(new HashMap<String, Object>() {
            {
                put("define", definition);
            }
        });
    }

    @Override
    public IGroovyLocalOptionsBuilder getCategoryOptions() {
        return new GroovyMapOptionsBuilder(localOptions);
    }

    @Override
    protected void putItem(Object object) {
        if (!list.contains(object)) {
            list.add(object);
        }
    }

    public void render(Closure<?> closure) {
        // ignored now
    }

    public void preClick(Closure<?> closure) {
        // ignored now
    }

    public void click(Closure<?> closure) {
        // ignored now
    }

    public void open(Closure<?> closure) {
        // ignored now
    }

    public void close(Closure<?> closure) {
        // ignored now
    }

    public void buy(Closure<?> closure) {
        // ignored now
    }
}
